<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Transaction::with(['user', 'items', 'paymentMethod']);

        // Invoice search
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('user_id') && $request->user_id !== 'all') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->whereHas('paymentMethod', function ($q) use ($request) {
                $q->where('slug', $request->payment_method);
            });
        }

        // Clone query for stats before pagination
        $statsQuery = clone $query;
        $totalTransactions = $statsQuery->count();
        $totalRevenue = $statsQuery->sum('final_amount');
        $avgTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Today's stats
        $todayTransactions = \App\Models\Transaction::whereDate('transaction_date', today())->count();
        $todayRevenue = \App\Models\Transaction::whereDate('transaction_date', today())->sum('final_amount');

        $transactions = $query->latest('transaction_date')->paginate(10)->withQueryString();
        $users = \App\Models\User::all();
        $paymentMethods = \App\Models\PaymentMethod::all();

        return view('transactions.index', compact(
            'transactions', 
            'users', 
            'paymentMethods',
            'totalTransactions',
            'totalRevenue',
            'avgTransaction',
            'todayTransactions',
            'todayRevenue'
        ));
    }

    public function show(\App\Models\Transaction $transaction)
    {
        $transaction->load(['items.product', 'user']);
        return view('transactions.show', compact('transaction'));
    }

    public function print(\App\Models\Transaction $transaction)
    {
        $transaction->load(['items.product', 'user']);
        return view('transactions.print', compact('transaction'));
    }

    public function downloadPdf(\App\Models\Transaction $transaction)
    {
        $transaction->load(['items.product', 'user', 'paymentMethod']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transactions.receipt-pdf', compact('transaction'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('struk-' . $transaction->invoice_number . '.pdf');
    }
}
