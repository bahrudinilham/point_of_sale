<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('settings.index', ['tab' => 'payment-methods']);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        PaymentMethod::create($validated);

        return redirect()->route('settings.index', ['tab' => 'payment-methods'])->with('success', 'Payment method created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return response()->json($paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        // Preserve current is_active status when updating name
        
        $paymentMethod->update($validated);

        return redirect()->route('settings.index', ['tab' => 'payment-methods'])->with('success', 'Payment method updated successfully.');
    }

    /**
     * Toggle the active status of a payment method.
     */
    public function toggleActive(PaymentMethod $paymentMethod)
    {
        $paymentMethod->update([
            'is_active' => !$paymentMethod->is_active
        ]);

        $status = $paymentMethod->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('settings.index', ['tab' => 'payment-methods'])
            ->with('success', "Metode pembayaran berhasil {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // Check if payment method is used in any transactions
        if ($paymentMethod->transactions()->count() > 0) {
            // Instead of blocking, offer to deactivate
            $paymentMethod->update(['is_active' => false]);
            return redirect()->route('settings.index', ['tab' => 'payment-methods'])
                ->with('success', 'Metode pembayaran tidak bisa dihapus karena sudah digunakan dalam transaksi, tetapi sudah dinonaktifkan.');
        }

        $paymentMethod->delete();
        return redirect()->route('settings.index', ['tab' => 'payment-methods'])->with('success', 'Payment method deleted successfully.');
    }
}
