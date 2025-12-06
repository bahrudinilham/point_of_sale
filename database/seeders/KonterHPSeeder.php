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
        $cashierNames = ['Budi Santoso', 'Siti Rahayu', 'Andi Pratama'];
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

        // Create 100 Products
        $products = [
            // Aksesoris HP (12 products)
            ['name' => 'Ring Holder Polos', 'category' => 'Aksesoris HP', 'purchase' => 3000, 'selling' => 8000, 'stock' => 150],
            ['name' => 'Ring Holder Karakter', 'category' => 'Aksesoris HP', 'purchase' => 5000, 'selling' => 12000, 'stock' => 100],
            ['name' => 'Pop Socket Universal', 'category' => 'Aksesoris HP', 'purchase' => 4000, 'selling' => 10000, 'stock' => 120],
            ['name' => 'Stylus Pen Capacitive', 'category' => 'Aksesoris HP', 'purchase' => 8000, 'selling' => 20000, 'stock' => 60],
            ['name' => 'Stylus Pen Premium', 'category' => 'Aksesoris HP', 'purchase' => 25000, 'selling' => 50000, 'stock' => 30],
            ['name' => 'Phone Holder Motor', 'category' => 'Aksesoris HP', 'purchase' => 15000, 'selling' => 35000, 'stock' => 40],
            ['name' => 'Phone Holder Mobil', 'category' => 'Aksesoris HP', 'purchase' => 20000, 'selling' => 45000, 'stock' => 35],
            ['name' => 'Tripod Mini HP', 'category' => 'Aksesoris HP', 'purchase' => 18000, 'selling' => 40000, 'stock' => 45],
            ['name' => 'Tongsis Bluetooth', 'category' => 'Aksesoris HP', 'purchase' => 30000, 'selling' => 65000, 'stock' => 25],
            ['name' => 'Gimbal Smartphone', 'category' => 'Aksesoris HP', 'purchase' => 150000, 'selling' => 280000, 'stock' => 10],
            ['name' => 'Lensa Clip On 3in1', 'category' => 'Aksesoris HP', 'purchase' => 20000, 'selling' => 45000, 'stock' => 40],
            ['name' => 'Ring Light Mini', 'category' => 'Aksesoris HP', 'purchase' => 25000, 'selling' => 55000, 'stock' => 30],

            // Kabel & Charger (15 products)
            ['name' => 'Kabel Data Micro USB 1M', 'category' => 'Kabel & Charger', 'purchase' => 5000, 'selling' => 12000, 'stock' => 200],
            ['name' => 'Kabel Data Type-C 1M', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 18000, 'stock' => 180],
            ['name' => 'Kabel Data Lightning 1M', 'category' => 'Kabel & Charger', 'purchase' => 12000, 'selling' => 28000, 'stock' => 120],
            ['name' => 'Kabel Data Micro USB 2M', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 18000, 'stock' => 100],
            ['name' => 'Kabel Data Type-C 2M', 'category' => 'Kabel & Charger', 'purchase' => 12000, 'selling' => 25000, 'stock' => 90],
            ['name' => 'Charger 2A Single Port', 'category' => 'Kabel & Charger', 'purchase' => 15000, 'selling' => 35000, 'stock' => 80],
            ['name' => 'Charger 2A Dual Port', 'category' => 'Kabel & Charger', 'purchase' => 20000, 'selling' => 45000, 'stock' => 70],
            ['name' => 'Charger Fast Charging 18W', 'category' => 'Kabel & Charger', 'purchase' => 35000, 'selling' => 75000, 'stock' => 50],
            ['name' => 'Charger Fast Charging 33W', 'category' => 'Kabel & Charger', 'purchase' => 50000, 'selling' => 100000, 'stock' => 40],
            ['name' => 'Charger Fast Charging 65W', 'category' => 'Kabel & Charger', 'purchase' => 80000, 'selling' => 150000, 'stock' => 25],
            ['name' => 'Wireless Charger 10W', 'category' => 'Kabel & Charger', 'purchase' => 45000, 'selling' => 95000, 'stock' => 30],
            ['name' => 'Wireless Charger 15W', 'category' => 'Kabel & Charger', 'purchase' => 65000, 'selling' => 130000, 'stock' => 20],
            ['name' => 'Charger Mobil 2 Port', 'category' => 'Kabel & Charger', 'purchase' => 18000, 'selling' => 40000, 'stock' => 45],
            ['name' => 'Charger Mobil Fast Charging', 'category' => 'Kabel & Charger', 'purchase' => 35000, 'selling' => 75000, 'stock' => 30],
            ['name' => 'OTG Adapter Type-C', 'category' => 'Kabel & Charger', 'purchase' => 8000, 'selling' => 20000, 'stock' => 60],

            // Casing & Pelindung (18 products)
            ['name' => 'Softcase Bening iPhone 12', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 80],
            ['name' => 'Softcase Bening iPhone 13', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 90],
            ['name' => 'Softcase Bening iPhone 14', 'category' => 'Casing & Pelindung', 'purchase' => 6000, 'selling' => 18000, 'stock' => 100],
            ['name' => 'Softcase Bening Samsung A54', 'category' => 'Casing & Pelindung', 'purchase' => 4000, 'selling' => 12000, 'stock' => 85],
            ['name' => 'Softcase Bening Samsung S23', 'category' => 'Casing & Pelindung', 'purchase' => 6000, 'selling' => 18000, 'stock' => 70],
            ['name' => 'Hardcase Shockproof iPhone', 'category' => 'Casing & Pelindung', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
            ['name' => 'Hardcase Shockproof Samsung', 'category' => 'Casing & Pelindung', 'purchase' => 12000, 'selling' => 30000, 'stock' => 55],
            ['name' => 'Flip Cover Leather iPhone', 'category' => 'Casing & Pelindung', 'purchase' => 25000, 'selling' => 55000, 'stock' => 35],
            ['name' => 'Flip Cover Leather Samsung', 'category' => 'Casing & Pelindung', 'purchase' => 20000, 'selling' => 48000, 'stock' => 40],
            ['name' => 'Tempered Glass iPhone 12', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 150],
            ['name' => 'Tempered Glass iPhone 13', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 160],
            ['name' => 'Tempered Glass iPhone 14', 'category' => 'Casing & Pelindung', 'purchase' => 6000, 'selling' => 18000, 'stock' => 140],
            ['name' => 'Tempered Glass Samsung A54', 'category' => 'Casing & Pelindung', 'purchase' => 4000, 'selling' => 12000, 'stock' => 130],
            ['name' => 'Tempered Glass Samsung S23', 'category' => 'Casing & Pelindung', 'purchase' => 8000, 'selling' => 22000, 'stock' => 80],
            ['name' => 'Hydrogel Screen Protector', 'category' => 'Casing & Pelindung', 'purchase' => 8000, 'selling' => 20000, 'stock' => 100],
            ['name' => 'Privacy Screen Protector', 'category' => 'Casing & Pelindung', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
            ['name' => 'Camera Lens Protector', 'category' => 'Casing & Pelindung', 'purchase' => 5000, 'selling' => 15000, 'stock' => 90],
            ['name' => 'Back Screen Protector', 'category' => 'Casing & Pelindung', 'purchase' => 3000, 'selling' => 10000, 'stock' => 80],

            // Audio (15 products)
            ['name' => 'Earphone Kabel 3.5mm', 'category' => 'Audio', 'purchase' => 8000, 'selling' => 20000, 'stock' => 100],
            ['name' => 'Earphone Kabel Type-C', 'category' => 'Audio', 'purchase' => 12000, 'selling' => 28000, 'stock' => 70],
            ['name' => 'Headset Gaming Kabel', 'category' => 'Audio', 'purchase' => 35000, 'selling' => 75000, 'stock' => 40],
            ['name' => 'TWS Bluetooth Budget', 'category' => 'Audio', 'purchase' => 25000, 'selling' => 55000, 'stock' => 60],
            ['name' => 'TWS Bluetooth Premium', 'category' => 'Audio', 'purchase' => 80000, 'selling' => 160000, 'stock' => 25],
            ['name' => 'TWS Gaming Low Latency', 'category' => 'Audio', 'purchase' => 60000, 'selling' => 120000, 'stock' => 30],
            ['name' => 'Headphone Bluetooth On-Ear', 'category' => 'Audio', 'purchase' => 70000, 'selling' => 140000, 'stock' => 20],
            ['name' => 'Headphone Bluetooth Over-Ear', 'category' => 'Audio', 'purchase' => 120000, 'selling' => 230000, 'stock' => 15],
            ['name' => 'Speaker Bluetooth Mini', 'category' => 'Audio', 'purchase' => 40000, 'selling' => 85000, 'stock' => 35],
            ['name' => 'Speaker Bluetooth Portable', 'category' => 'Audio', 'purchase' => 80000, 'selling' => 160000, 'stock' => 20],
            ['name' => 'Speaker Bluetooth Waterproof', 'category' => 'Audio', 'purchase' => 100000, 'selling' => 195000, 'stock' => 15],
            ['name' => 'Splitter Audio 3.5mm', 'category' => 'Audio', 'purchase' => 5000, 'selling' => 12000, 'stock' => 50],
            ['name' => 'Adapter Audio Type-C', 'category' => 'Audio', 'purchase' => 10000, 'selling' => 25000, 'stock' => 70],
            ['name' => 'Microphone Clip On', 'category' => 'Audio', 'purchase' => 20000, 'selling' => 45000, 'stock' => 40],
            ['name' => 'Microphone Wireless', 'category' => 'Audio', 'purchase' => 80000, 'selling' => 165000, 'stock' => 15],

            // Kartu & Pulsa (10 products)
            ['name' => 'Kartu Perdana Telkomsel', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 200],
            ['name' => 'Kartu Perdana XL', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 180],
            ['name' => 'Kartu Perdana Indosat', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 170],
            ['name' => 'Kartu Perdana Tri', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 160],
            ['name' => 'Kartu Perdana Smartfren', 'category' => 'Kartu & Pulsa', 'purchase' => 3000, 'selling' => 10000, 'stock' => 140],
            ['name' => 'Voucher Pulsa 10K', 'category' => 'Kartu & Pulsa', 'purchase' => 9500, 'selling' => 11000, 'stock' => 100],
            ['name' => 'Voucher Pulsa 25K', 'category' => 'Kartu & Pulsa', 'purchase' => 24000, 'selling' => 26000, 'stock' => 80],
            ['name' => 'Voucher Pulsa 50K', 'category' => 'Kartu & Pulsa', 'purchase' => 48500, 'selling' => 51000, 'stock' => 60],
            ['name' => 'Voucher Pulsa 100K', 'category' => 'Kartu & Pulsa', 'purchase' => 97000, 'selling' => 101000, 'stock' => 40],
            ['name' => 'Voucher Data 5GB', 'category' => 'Kartu & Pulsa', 'purchase' => 28000, 'selling' => 35000, 'stock' => 50],

            // Perlengkapan (15 products)
            ['name' => 'Cleaning Kit HP', 'category' => 'Perlengkapan', 'purchase' => 10000, 'selling' => 25000, 'stock' => 60],
            ['name' => 'Kain Microfiber', 'category' => 'Perlengkapan', 'purchase' => 2000, 'selling' => 6000, 'stock' => 150],
            ['name' => 'Sim Card Ejector', 'category' => 'Perlengkapan', 'purchase' => 500, 'selling' => 2000, 'stock' => 300],
            ['name' => 'Pouch HP Universal', 'category' => 'Perlengkapan', 'purchase' => 8000, 'selling' => 20000, 'stock' => 70],
            ['name' => 'Armband Running', 'category' => 'Perlengkapan', 'purchase' => 12000, 'selling' => 30000, 'stock' => 45],
            ['name' => 'Waterproof Case HP', 'category' => 'Perlengkapan', 'purchase' => 15000, 'selling' => 35000, 'stock' => 40],
            ['name' => 'Cable Organizer', 'category' => 'Perlengkapan', 'purchase' => 5000, 'selling' => 12000, 'stock' => 80],
            ['name' => 'Cable Protector', 'category' => 'Perlengkapan', 'purchase' => 2000, 'selling' => 5000, 'stock' => 200],
            ['name' => 'Dust Plug Set', 'category' => 'Perlengkapan', 'purchase' => 2000, 'selling' => 6000, 'stock' => 120],
            ['name' => 'Phone Stand Desktop', 'category' => 'Perlengkapan', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
            ['name' => 'Tablet Stand Adjustable', 'category' => 'Perlengkapan', 'purchase' => 30000, 'selling' => 65000, 'stock' => 25],
            ['name' => 'Laptop Stand Portable', 'category' => 'Perlengkapan', 'purchase' => 45000, 'selling' => 95000, 'stock' => 20],
            ['name' => 'USB Hub 4 Port', 'category' => 'Perlengkapan', 'purchase' => 25000, 'selling' => 55000, 'stock' => 35],
            ['name' => 'USB Hub Type-C 6in1', 'category' => 'Perlengkapan', 'purchase' => 80000, 'selling' => 165000, 'stock' => 15],
            ['name' => 'Mouse Wireless', 'category' => 'Perlengkapan', 'purchase' => 35000, 'selling' => 75000, 'stock' => 30],

            // Powerbank (8 products)
            ['name' => 'Powerbank 5000mAh Slim', 'category' => 'Powerbank', 'purchase' => 45000, 'selling' => 95000, 'stock' => 40],
            ['name' => 'Powerbank 10000mAh', 'category' => 'Powerbank', 'purchase' => 70000, 'selling' => 140000, 'stock' => 35],
            ['name' => 'Powerbank 10000mAh Fast Charging', 'category' => 'Powerbank', 'purchase' => 90000, 'selling' => 175000, 'stock' => 30],
            ['name' => 'Powerbank 20000mAh', 'category' => 'Powerbank', 'purchase' => 120000, 'selling' => 230000, 'stock' => 25],
            ['name' => 'Powerbank 20000mAh Fast Charging', 'category' => 'Powerbank', 'purchase' => 150000, 'selling' => 285000, 'stock' => 20],
            ['name' => 'Powerbank Wireless 10000mAh', 'category' => 'Powerbank', 'purchase' => 130000, 'selling' => 250000, 'stock' => 15],
            ['name' => 'Powerbank Solar 20000mAh', 'category' => 'Powerbank', 'purchase' => 100000, 'selling' => 195000, 'stock' => 20],
            ['name' => 'Powerbank Mini 3000mAh', 'category' => 'Powerbank', 'purchase' => 30000, 'selling' => 65000, 'stock' => 50],

            // Memory & Storage (7 products)
            ['name' => 'MicroSD 16GB Class 10', 'category' => 'Memory & Storage', 'purchase' => 25000, 'selling' => 50000, 'stock' => 60],
            ['name' => 'MicroSD 32GB Class 10', 'category' => 'Memory & Storage', 'purchase' => 40000, 'selling' => 80000, 'stock' => 50],
            ['name' => 'MicroSD 64GB Class 10', 'category' => 'Memory & Storage', 'purchase' => 60000, 'selling' => 115000, 'stock' => 40],
            ['name' => 'MicroSD 128GB Class 10', 'category' => 'Memory & Storage', 'purchase' => 100000, 'selling' => 185000, 'stock' => 30],
            ['name' => 'Flashdisk 16GB USB 3.0', 'category' => 'Memory & Storage', 'purchase' => 30000, 'selling' => 60000, 'stock' => 45],
            ['name' => 'Flashdisk 32GB USB 3.0', 'category' => 'Memory & Storage', 'purchase' => 45000, 'selling' => 90000, 'stock' => 35],
            ['name' => 'Card Reader USB Type-C', 'category' => 'Memory & Storage', 'purchase' => 15000, 'selling' => 35000, 'stock' => 50],
        ];

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

        // Generate transactions for January - December 2025
        $allCashiers = array_merge([$admin], $cashiers);
        $allProducts = Product::all();
        
        $this->command->info('Generating transactions for 2025...');
        
        for ($month = 1; $month <= 12; $month++) {
            // More transactions on weekends, less on weekdays
            // Also seasonal variations (more sales in holiday seasons)
            $baseTransactionsPerDay = match($month) {
                1 => 12,   // New Year
                2 => 8,    // Normal
                3 => 8,    // Normal
                4 => 9,    // Ramadan start
                5 => 15,   // Eid
                6 => 10,   // School holiday
                7 => 9,    // Normal
                8 => 8,    // Normal
                9 => 8,    // Normal
                10 => 9,   // Normal
                11 => 10,  // 11.11 Sale
                12 => 14,  // Christmas & Year End
                default => 8,
            };

            $daysInMonth = Carbon::create(2025, $month)->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create(2025, $month, $day);
                
                // Skip future dates if current month
                if ($date->isFuture()) {
                    continue;
                }
                
                // Vary transactions based on day of week
                $dayMultiplier = $date->isWeekend() ? 1.5 : 1.0;
                $transactionsToday = (int) ($baseTransactionsPerDay * $dayMultiplier * (0.7 + (rand(0, 60) / 100)));
                
                for ($t = 0; $t < $transactionsToday; $t++) {
                    // Random time between 08:00 and 21:00
                    $hour = rand(8, 20);
                    $minute = rand(0, 59);
                    $transactionDate = $date->copy()->setTime($hour, $minute, rand(0, 59));
                    
                    // Random cashier (60% cashiers, 40% admin)
                    $user = rand(1, 10) <= 4 ? $admin : $cashiers[array_rand($cashiers)];
                    
                    // Random payment method
                    $paymentMethod = $allPaymentMethods->random();
                    
                    // Generate items (1-5 items per transaction)
                    $itemCount = rand(1, 5);
                    $selectedProducts = $allProducts->random($itemCount);
                    
                    $totalAmount = 0;
                    $items = [];
                    
                    foreach ($selectedProducts as $product) {
                        $quantity = rand(1, 3);
                        $subtotal = $product->selling_price * $quantity;
                        $totalAmount += $subtotal;
                        
                        $items[] = [
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $product->selling_price,
                            'subtotal' => $subtotal,
                        ];
                    }
                    
                    // Calculate payment (cash sometimes has change)
                    $cashReceived = $totalAmount;
                    $changeAmount = 0;
                    
                    if ($paymentMethod->slug === 'tunai') {
                        // Round up to nearest 5000 or 10000
                        $roundedCash = ceil($totalAmount / 10000) * 10000;
                        if ($roundedCash - $totalAmount < 5000 && $totalAmount > 50000) {
                            $roundedCash += 10000;
                        }
                        $cashReceived = max($roundedCash, $totalAmount);
                        $changeAmount = $cashReceived - $totalAmount;
                    }
                    
                    // Create transaction
                    $transaction = Transaction::create([
                        'invoice_number' => 'INV-' . $transactionDate->format('Ymd') . '-' . strtoupper(Str::random(8)),
                        'user_id' => $user->id,
                        'payment_method_id' => $paymentMethod->id,
                        'total_amount' => $totalAmount,
                        'final_amount' => $totalAmount,
                        'cash_received' => $cashReceived,
                        'change_amount' => $changeAmount,
                        'transaction_date' => $transactionDate,
                        'created_at' => $transactionDate,
                        'updated_at' => $transactionDate,
                    ]);
                    
                    // Create transaction items
                    foreach ($items as $item) {
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'subtotal' => $item['subtotal'],
                        ]);
                    }
                }
            }
            
            $this->command->info("Month $month completed.");
        }

        $totalTransactions = Transaction::count();
        $this->command->info("Seeding completed! Created $totalTransactions transactions.");
    }
}
