<?php

namespace App\Http\Controllers;

use App\Models\ArchivedTransaction;
use App\Models\ArchivedTransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    /**
     * Display archived transactions.
     */
    public function index(Request $request)
    {
        $query = ArchivedTransaction::with(['items']);

        // Search by invoice
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        // Date filters
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $archivedTransactions = $query->latest('transaction_date')->paginate(15)->withQueryString();
        
        // Stats
        $totalArchived = ArchivedTransaction::count();
        $totalArchivedAmount = ArchivedTransaction::sum('final_amount');
        $oldestArchived = ArchivedTransaction::min('transaction_date');
        $newestArchived = ArchivedTransaction::max('transaction_date');
        
        // Active transaction stats for comparison
        $totalActive = Transaction::count();
        $oldestActive = Transaction::min('transaction_date');

        return view('archive.index', compact(
            'archivedTransactions',
            'totalArchived',
            'totalArchivedAmount',
            'oldestArchived',
            'newestArchived',
            'totalActive',
            'oldestActive'
        ));
    }

    /**
     * Show archived transaction details.
     */
    public function show(ArchivedTransaction $archivedTransaction)
    {
        $archivedTransaction->load('items');
        return view('archive.show', compact('archivedTransaction'));
    }

    /**
     * Archive old transactions via web interface.
     */
    public function archive(Request $request)
    {
        $request->validate([
            'months' => 'required|integer|min:1|max:60'
        ]);
        
        $months = $request->months;
        $cutoffDate = now()->subMonths($months);
        
        // Get transactions to archive
        $transactions = Transaction::with(['user', 'items.product', 'paymentMethod'])
            ->where('transaction_date', '<', $cutoffDate)
            ->get();
        
        if ($transactions->isEmpty()) {
            return back()->with('info', 'Tidak ada transaksi yang perlu diarsipkan.');
        }
        
        $archived = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($transactions as $transaction) {
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
                
                // Delete original transaction
                $transaction->delete();
                $archived++;
            }
            
            DB::commit();
            
            return back()->with('success', "Berhasil mengarsipkan {$archived} transaksi.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengarsipkan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Restore an archived transaction back to active.
     */
    public function restore(ArchivedTransaction $archivedTransaction)
    {
        DB::beginTransaction();
        
        try {
            // Check if invoice number already exists in active transactions
            if (Transaction::where('invoice_number', $archivedTransaction->invoice_number)->exists()) {
                return back()->with('error', 'Transaksi dengan nomor invoice ini sudah ada di data aktif.');
            }
            
            // Create new transaction from archived data
            $transaction = Transaction::create([
                'invoice_number' => $archivedTransaction->invoice_number,
                'user_id' => $archivedTransaction->user_id,
                'total_amount' => $archivedTransaction->total_amount,
                'final_amount' => $archivedTransaction->final_amount,
                'cash_received' => $archivedTransaction->cash_received,
                'change_amount' => $archivedTransaction->change_amount,
                'payment_method_id' => $archivedTransaction->payment_method_id,
                'transaction_date' => $archivedTransaction->transaction_date,
            ]);
            
            // Restore transaction items
            foreach ($archivedTransaction->items as $item) {
                $transaction->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                    'note' => $item->note,
                ]);
            }
            
            // Delete archived transaction
            $archivedTransaction->delete();
            
            DB::commit();
            
            return redirect()->route('archive.index')
                ->with('success', 'Transaksi berhasil dipulihkan ke data aktif.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulihkan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete old archived data.
     */
    public function purge(Request $request)
    {
        $request->validate([
            'months' => 'required|integer|min:6|max:120'
        ]);
        
        $months = $request->months;
        $cutoffDate = now()->subMonths($months);
        
        // Get archived transactions to purge (based on transaction_date, not archived_at)
        $toDelete = ArchivedTransaction::where('transaction_date', '<', $cutoffDate);
        $count = $toDelete->count();
        
        if ($count === 0) {
            return back()->with('info', 'Tidak ada data arsip yang perlu dihapus.');
        }
        
        try {
            // Delete will cascade to archived_transaction_items due to foreign key
            $toDelete->delete();
            
            return back()->with('success', "Berhasil menghapus permanen {$count} transaksi arsip.");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data arsip: ' . $e->getMessage());
        }
    }

    /**
     * Delete a single archived transaction permanently.
     */
    public function destroy(ArchivedTransaction $archivedTransaction)
    {
        try {
            $invoice = $archivedTransaction->invoice_number;
            $archivedTransaction->delete();
            
            return back()->with('success', "Berhasil menghapus arsip transaksi {$invoice}.");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus arsip: ' . $e->getMessage());
        }
    }
}
