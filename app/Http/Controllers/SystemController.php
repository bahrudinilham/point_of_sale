<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use Database\Seeders\KonterHPSeeder;

class SystemController extends Controller
{
    public function resetDatabase(Request $request)
    {
        // Security: Ensure only admin can do this
        if ($request->user() && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            // Increase execution time for large seeding
            set_time_limit(300); // 5 minutes

            // Run Seeder (It handles truncation internally)
            $seeder = app()->make(KonterHPSeeder::class);
            $seeder->run();

            return response()->json([
                'success' => true, 
                'message' => 'Database has been reset and seeded successfully.',
                'total_transactions' => Transaction::count(),
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Reset failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Reset failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
