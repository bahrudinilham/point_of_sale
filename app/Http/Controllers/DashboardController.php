<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now();
        $yesterday = now()->subDay();
        
        // Today's stats (using whereDate for accurate "today only" results)
        $todaySales = \App\Models\Transaction::whereDate('transaction_date', $today)->sum('final_amount');
        $todayTransactions = \App\Models\Transaction::whereDate('transaction_date', $today)->count();
        $todayItems = \App\Models\TransactionItem::whereHas('transaction', function($q) use ($today) {
            $q->whereDate('transaction_date', $today);
        })->sum('quantity');
        
        // Yesterday's stats for comparison
        $yesterdaySales = \App\Models\Transaction::whereDate('transaction_date', $yesterday)->sum('final_amount');
        $yesterdayTransactions = \App\Models\Transaction::whereDate('transaction_date', $yesterday)->count();
        
        // Calculate percentage changes
        $salesChange = $yesterdaySales > 0 ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 : ($todaySales > 0 ? 100 : 0);
        $transactionsChange = $yesterdayTransactions > 0 ? (($todayTransactions - $yesterdayTransactions) / $yesterdayTransactions) * 100 : ($todayTransactions > 0 ? 100 : 0);
        
        $recentTransactions = \App\Models\Transaction::with(['user', 'paymentMethod'])->latest()->take(5)->get();

        // Weekly Chart Data
        $weeklySales = [];
        $weeklyLabels = [];
        $startDateWeekly = now()->subDays(6);
        $endDateWeekly = now();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyLabels[] = $date->format('d M');
            $weeklySales[] = \App\Models\Transaction::whereDate('transaction_date', $date)->sum('final_amount');
        }
        
        $weeklyTotal = array_sum($weeklySales);

        // Top Products Today
        $topProductsToday = \App\Models\TransactionItem::with('product')
            ->whereHas('transaction', function($q) use ($today) {
                $q->whereDate('transaction_date', $today);
            })
            ->selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Payment Method Breakdown Today
        $paymentBreakdown = \App\Models\Transaction::with('paymentMethod')
            ->whereDate('transaction_date', $today)
            ->selectRaw('payment_method_id, SUM(final_amount) as total_amount, COUNT(*) as count')
            ->groupBy('payment_method_id')
            ->orderByDesc('total_amount')
            ->get();

        // Low Stock Products
        $lowStockCount = \App\Models\Product::where('stock', '<=', 10)->count();
        $lowStockProducts = \App\Models\Product::where('stock', '<=', 10)->with('category')->orderBy('stock', 'asc')->get();

        return view('dashboard', compact(
            'todaySales', 'todayTransactions', 'todayItems', 'recentTransactions', 
            'weeklySales', 'weeklyLabels', 'startDateWeekly', 'endDateWeekly', 'weeklyTotal',
            'lowStockCount', 'lowStockProducts',
            'salesChange', 'transactionsChange',
            'topProductsToday', 'paymentBreakdown'
        ));
    }
}
