<?php

namespace App\Console\Commands;

use App\Models\ArchivedTransaction;
use App\Models\ArchivedTransactionItem;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveOldTransactions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'transactions:archive 
                            {--months=6 : Number of months to keep in active database}
                            {--dry-run : Show what would be archived without actually archiving}';

    /**
     * The console command description.
     */
    protected $description = 'Archive transactions older than specified months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $months = (int) $this->option('months');
        $dryRun = $this->option('dry-run');
        
        $cutoffDate = now()->subMonths($months);
        
        $this->info("Archiving transactions older than {$cutoffDate->format('Y-m-d')}...");
        
        // Get transactions to archive
        $transactions = Transaction::with(['user', 'items.product', 'paymentMethod'])
            ->where('transaction_date', '<', $cutoffDate)
            ->get();
        
        $count = $transactions->count();
        
        if ($count === 0) {
            $this->info('No transactions to archive.');
            return 0;
        }
        
        $this->info("Found {$count} transactions to archive.");
        
        if ($dryRun) {
            $this->warn('DRY RUN - No changes will be made.');
            $this->table(
                ['Invoice', 'Date', 'Amount', 'Items'],
                $transactions->take(10)->map(fn($t) => [
                    $t->invoice_number,
                    $t->transaction_date->format('Y-m-d'),
                    'Rp ' . number_format($t->final_amount, 0, ',', '.'),
                    $t->items->count()
                ])
            );
            if ($count > 10) {
                $this->info("... and " . ($count - 10) . " more transactions.");
            }
            return 0;
        }
        
        if (!$this->confirm("Are you sure you want to archive {$count} transactions?")) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        
        $archived = 0;
        $errors = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($transactions as $transaction) {
                try {
                    // Create archived transaction
                    $archivedTransaction = ArchivedTransaction::create([
                        'original_id' => $transaction->id,
                        'invoice_number' => $transaction->invoice_number,
                        'user_id' => $transaction->user_id,
                        'total_amount' => $transaction->total_amount,
                        'final_amount' => $transaction->final_amount,
                        'cash_received' => $transaction->cash_received,
                        'change_amount' => $transaction->change_amount,
                        'payment_method_id' => $transaction->payment_method_id,
                        'transaction_date' => $transaction->transaction_date,
                        'archived_at' => now(),
                        'user_name' => $transaction->user?->name,
                        'payment_method_name' => $transaction->paymentMethod?->name,
                    ]);
                    
                    // Archive transaction items
                    foreach ($transaction->items as $item) {
                        ArchivedTransactionItem::create([
                            'original_id' => $item->id,
                            'archived_transaction_id' => $archivedTransaction->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                            'subtotal' => $item->subtotal,
                            'note' => $item->note ?? null,
                            'product_name' => $item->product?->name,
                        ]);
                    }
                    
                    // Delete original transaction (items will cascade)
                    $transaction->delete();
                    
                    $archived++;
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("\nError archiving transaction {$transaction->invoice_number}: {$e->getMessage()}");
                }
                
                $bar->advance();
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("\nTransaction failed: {$e->getMessage()}");
            return 1;
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Successfully archived {$archived} transactions.");
        if ($errors > 0) {
            $this->warn("⚠️  {$errors} transactions failed to archive.");
        }
        
        return 0;
    }
}
