<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;

class KonterHPSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for MySQL compatibility
        Schema::disableForeignKeyConstraints();
        
        // Clear existing data (also clear archived tables)
        DB::table('archived_transaction_items')->truncate();
        DB::table('archived_transactions')->truncate();
        TransactionItem::truncate();
        Transaction::truncate();
        Product::truncate();
        Category::truncate();
        PaymentMethod::query()->forceDelete();
        User::truncate();
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Create Users (1 Admin + 3 Cashiers)
        $admin = User::create([
            'name' => 'Admin Konter',
            'email' => 'admin@konter.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $cashiers = [];
        $cashierNames = ['Siti Rahayu', 'Andi Pratama']; // 2 Cashiers
        foreach ($cashierNames as $index => $name) {
            $cashiers[] = User::create([
                'name' => $name,
                'email' => strtolower(explode(' ', $name)[0]) . '@konter.com',
                'password' => Hash::make('password'),
                'role' => 'cashier',
                'is_active' => true,
            ]);
        }

        // Create Payment Methods
        $paymentMethods = [
            ['name' => 'Tunai', 'slug' => 'tunai'],
            ['name' => 'QRIS', 'slug' => 'qris'],
            ['name' => 'Transfer BCA', 'slug' => 'transfer-bca'],
            ['name' => 'Transfer Mandiri', 'slug' => 'transfer-mandiri'],
            ['name' => 'OVO', 'slug' => 'ovo'],
            ['name' => 'GoPay', 'slug' => 'gopay'],
            ['name' => 'Dana', 'slug' => 'dana'],
        ];

        foreach ($paymentMethods as $pm) {
            PaymentMethod::create([
                'name' => $pm['name'],
                'slug' => $pm['slug'],
                'is_active' => true,
            ]);
        }
        $allPaymentMethods = PaymentMethod::all();

        // Create Categories
        $categories = [
            ['name' => 'Aksesoris HP', 'slug' => 'aksesoris-hp'],
            ['name' => 'Kabel & Charger', 'slug' => 'kabel-charger'],
            ['name' => 'Casing & Pelindung', 'slug' => 'casing-pelindung'],
            ['name' => 'Audio', 'slug' => 'audio'],
            ['name' => 'Kartu & Pulsa', 'slug' => 'kartu-pulsa'],
            ['name' => 'Perlengkapan', 'slug' => 'perlengkapan'],
            ['name' => 'Powerbank', 'slug' => 'powerbank'],
            ['name' => 'Memory & Storage', 'slug' => 'memory-storage'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
            ]);
        }

        // Create 50 Products (Reduced list)
        $productsSource = [
            // Aksesoris HP
            ['name' => 'Ring Holder Polos', 'category' => 'Aksesoris HP', 'purchase' => 3000, 'selling' => 8000, 'stock' => 150],
            ['name' => 'Ring Holder Karakter', 'category' => 'Aksesoris HP', 'purchase' => 5000, 'selling' => 12000, 'stock' => 100],
            ['name' => 'Pop Socket Universal', 'category' => 'Aksesoris HP', 'purchase' => 4000, 'selling' => 10000, 'stock' => 120],
            ['name' => 'Stylus Pen Capacitive', 'category' => 'Aksesoris HP', 'purchase' => 8000, 'selling' => 20000, 'stock' => 60],
            ['name' => 'Phone Holder Motor', 'category' => 'Aksesoris HP', 'purchase' => 15000, 'selling' => 35000, 'stock' => 40],
            ['name' => 'Tripod Mini HP', 'category' => 'Aksesoris HP', 'purchase' => 18000, 'selling' => 40000, 'stock' => 45],
            ['name' => 'Tongsis Bluetooth', 'category' => 'Aksesoris HP', 'purchase' => 30000, 'selling' => 65000, 'stock' => 25],

            // Kabel & Charger
            ['name' => 'Kabel Data Micro USB 1M', 'category' => 'Kabel & Charger', 'purchase' => 5000, 'selling' => 12000, 'stock' => 200],
            ['name' => 'Kabel Data Type-C 1M', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 18000, 'stock' => 180],
            ['name' => 'Kabel Data Lightning 1M', 'category' => 'Kabel & Charger', 'purchase' => 12000, 'selling' => 28000, 'stock' => 120],
            ['name' => 'Charger 2A Single Port', 'category' => 'Kabel & Charger', 'purchase' => 15000, 'selling' => 35000, 'stock' => 80],
            ['name' => 'Charger Fast Charging 18W', 'category' => 'Kabel & Charger', 'purchase' => 35000, 'selling' => 75000, 'stock' => 50],
            ['name' => 'Charger Mobil Fast Charging', 'category' => 'Kabel & Charger', 'purchase' => 35000, 'selling' => 75000, 'stock' => 30],

            // Casing & Pelindung
            ['name' => 'Softcase Bening iPhone 12', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 80],
            ['name' => 'Softcase Bening Samsung A54', 'category' => 'Casing & Pelindung', 'purchase' => 4000, 'selling' => 12000, 'stock' => 85],
            ['name' => 'Tempered Glass iPhone 12', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 150],
            ['name' => 'Tempered Glass Samsung S23', 'category' => 'Casing & Pelindung', 'purchase' => 8000, 'selling' => 22000, 'stock' => 80],
            ['name' => 'Hydrogel Screen Protector', 'category' => 'Casing & Pelindung', 'purchase' => 8000, 'selling' => 20000, 'stock' => 100],

            // Audio
            ['name' => 'Earphone Kabel 3.5mm', 'category' => 'Audio', 'purchase' => 8000, 'selling' => 20000, 'stock' => 100],
            ['name' => 'Earphone Kabel Type-C', 'category' => 'Audio', 'purchase' => 12000, 'selling' => 28000, 'stock' => 70],
            ['name' => 'Headset Gaming Kabel', 'category' => 'Audio', 'purchase' => 35000, 'selling' => 75000, 'stock' => 40],
            ['name' => 'TWS Bluetooth Budget', 'category' => 'Audio', 'purchase' => 25000, 'selling' => 55000, 'stock' => 60],
            ['name' => 'Speaker Bluetooth Mini', 'category' => 'Audio', 'purchase' => 40000, 'selling' => 85000, 'stock' => 35],

            // Kartu & Pulsa
            ['name' => 'Kartu Perdana Telkomsel', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 200],
            ['name' => 'Kartu Perdana XL', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 180],
            ['name' => 'Kartu Perdana Indosat', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 170],
            // Removed Vouchers as requested

            // Perlengkapan
            ['name' => 'Cleaning Kit HP', 'category' => 'Perlengkapan', 'purchase' => 10000, 'selling' => 25000, 'stock' => 60],
            ['name' => 'Kain Microfiber', 'category' => 'Perlengkapan', 'purchase' => 2000, 'selling' => 6000, 'stock' => 150],
            ['name' => 'Sim Card Ejector', 'category' => 'Perlengkapan', 'purchase' => 500, 'selling' => 2000, 'stock' => 300],
            ['name' => 'Waterproof Case HP', 'category' => 'Perlengkapan', 'purchase' => 15000, 'selling' => 35000, 'stock' => 40],
            ['name' => 'Cable Protector', 'category' => 'Perlengkapan', 'purchase' => 2000, 'selling' => 5000, 'stock' => 200],
            ['name' => 'Phone Stand Desktop', 'category' => 'Perlengkapan', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
            ['name' => 'OTG Adapter Type-C', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 20000, 'stock' => 60],
            ['name' => 'Flashdisk 16GB USB 3.0', 'category' => 'Memory & Storage', 'purchase' => 30000, 'selling' => 60000, 'stock' => 45],
            ['name' => 'Card Reader USB Type-C', 'category' => 'Memory & Storage', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
            
            // Fillers to reach 50
            ['name' => 'Powerbank 5000mAh', 'category' => 'Powerbank', 'purchase' => 45000, 'selling' => 95000, 'stock' => 40],
            ['name' => 'Powerbank 10000mAh', 'category' => 'Powerbank', 'purchase' => 70000, 'selling' => 140000, 'stock' => 35],
            ['name' => 'MicroSD 32GB', 'category' => 'Memory & Storage', 'purchase' => 40000, 'selling' => 80000, 'stock' => 50],
            ['name' => 'Kabel Data Micro USB 2M', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 18000, 'stock' => 100],
            ['name' => 'Kabel Data Type-C 2M', 'category' => 'Kabel & Charger', 'purchase' => 12000, 'selling' => 25000, 'stock' => 90],
            ['name' => 'Charger Mobil 2 Port', 'category' => 'Kabel & Charger', 'purchase' => 18000, 'selling' => 40000, 'stock' => 45],
            ['name' => 'Softcase Bening iPhone 13', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 90],
            ['name' => 'Tempered Glass iPhone 13', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 160],
            ['name' => 'Voucher Pulsa 10K', 'category' => 'Kartu & Pulsa', 'purchase' => 9500, 'selling' => 11000, 'stock' => 100], // Re-added filler to match roughly 50 if needed, or remove. Actually user asked to remove them. I will remove them and add other generic items to maintain count if needed, or just let it be less than 50. User said "buat 10 product stok rendah", I'll likely just modify the array values. 
        ];

        // Ensure exactly 50 products? User didn't strictly say 50 again, but "hapus voucher pulsa". The previous list had fillers.
        // Let's remove the vouchers and *then* set low stock on the first 10.
        
        $productsSource = array_filter($productsSource, function($p) {
            return !str_contains($p['name'], 'Voucher');
        });
        
        // Re-index array
        $productsSource = array_values($productsSource);
        
        // Set first 10 to low stock
        for ($i = 0; $i < 10; $i++) {
            if (isset($productsSource[$i])) {
                $productsSource[$i]['stock'] = rand(3, 8);
            }
        }

        // Slice to 50 (or less if we deleted some)
        $products = array_slice($productsSource, 0, 50);

        // Create products
        $allCategories = Category::all()->keyBy('name');
        $createdProducts = [];
        
        foreach ($products as $product) {
            $createdProducts[] = Product::create([
                'name' => $product['name'],
                'category_id' => $allCategories[$product['category']]->id,
                'purchase_price' => $product['purchase'],
                'selling_price' => $product['selling'],
                'stock' => $product['stock'],
                'is_active' => true,
            ]);
        }

        // Generate transactions for January 2025 - January 2026
        $allCashiers = array_merge([$admin], $cashiers);
        
        // Optimasi: Eager loading untuk menghindari query berulang
        // Namun karena kita pakai ID manual, kita cuma butuh ID-nya saja dari produk
        $productIds = Product::pluck('selling_price', 'id')->toArray();
        $productKeys = array_keys($productIds);
        
        $this->command->info('Generating transactions for 2025-2026...');
        
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2026, 1, 31);
        
        $transactionsBuffer = [];
        $transactionItemsBuffer = [];
        $bufferSize = 500; // Insert setiap 500 transaksi
        
        // KITA HARUS MANUAL MAININ ID KARENA BATCH INSERT TIDAK MENGEMBALIKAN ID
        // Asumsi tabel sudah di-truncate, jadi ID mulai dari 1
        $currentTransactionId = 1;
        
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $month = $date->month;
            
            // Pola transaksi yang sama
            $baseTransactionsPerDay = match($month) {
                1 => 12, 2 => 8, 3 => 8, 4 => 9, 5 => 15, 6 => 10,
                7 => 9, 8 => 8, 9 => 8, 10 => 9, 11 => 10, 12 => 14,
                default => 8,
            };

            $dayMultiplier = $date->isWeekend() ? 1.5 : 1.0;
            $transactionsToday = (int) ($baseTransactionsPerDay * $dayMultiplier * (0.7 + (rand(0, 60) / 100)));
            
            for ($t = 0; $t < $transactionsToday; $t++) {
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $transactionDate = $date->copy()->setTime($hour, $minute, rand(0, 59))->toDateTimeString(); // String format untuk insert
                
                $user = rand(1, 10) <= 4 ? $admin : $cashiers[array_rand($cashiers)];
                $paymentMethod = $allPaymentMethods->random();
                
                // Item generation
                $itemCount = rand(1, 5);
                // Pilih produk random
                $selectedProductKeys = [];
                for($k=0; $k<$itemCount; $k++) {
                    $selectedProductKeys[] = $productKeys[array_rand($productKeys)];
                }

                $totalAmount = 0;
                
                foreach ($selectedProductKeys as $pId) {
                    $sellingPrice = $productIds[$pId];
                    $quantity = rand(1, 3);
                    $subtotal = $sellingPrice * $quantity;
                    $totalAmount += $subtotal;
                    
                    $transactionItemsBuffer[] = [
                        'transaction_id' => $currentTransactionId,
                        'product_id' => $pId,
                        'quantity' => $quantity,
                        'unit_price' => $sellingPrice,
                        'subtotal' => $subtotal,
                        'created_at' => $transactionDate,
                        'updated_at' => $transactionDate,
                    ];
                }
                
                // Payment calculation
                $cashReceived = $totalAmount;
                $changeAmount = 0;
                
                if ($paymentMethod->slug === 'tunai') {
                    $roundedCash = ceil($totalAmount / 10000) * 10000;
                    if ($roundedCash - $totalAmount < 5000 && $totalAmount > 50000) {
                        $roundedCash += 10000;
                    }
                    $cashReceived = max($roundedCash, $totalAmount);
                    $changeAmount = $cashReceived - $totalAmount;
                }
                
                $transactionsBuffer[] = [
                    'id' => $currentTransactionId,
                    'invoice_number' => 'INV-' . date('Ymd', strtotime($transactionDate)) . '-' . strtoupper(Str::random(8)),
                    'user_id' => $user->id,
                    'payment_method_id' => $paymentMethod->id,
                    'total_amount' => $totalAmount,
                    'final_amount' => $totalAmount,
                    'cash_received' => $cashReceived,
                    'change_amount' => $changeAmount,
                    'transaction_date' => $transactionDate,
                    'created_at' => $transactionDate,
                    'updated_at' => $transactionDate,
                ];
                
                $currentTransactionId++; // Increment manual ID
                
                // BATCH INSERT JIKA BUFFER PENUH
                if (count($transactionsBuffer) >= $bufferSize) {
                    Transaction::insert($transactionsBuffer);
                    TransactionItem::insert($transactionItemsBuffer);
                    
                    // Reset buffer
                    $transactionsBuffer = [];
                    $transactionItemsBuffer = [];
                    
                    $this->command->info("Inserted batch up to ID: " . ($currentTransactionId - 1));
                }
            }
        }
        
        // INSERT SISA BUFFER TERAKHIR
        if (!empty($transactionsBuffer)) {
            Transaction::insert($transactionsBuffer);
            TransactionItem::insert($transactionItemsBuffer);
        }

        $totalTransactions = Transaction::count();
        $this->command->info("Seeding completed! Created $totalTransactions transactions.");
    }
}
