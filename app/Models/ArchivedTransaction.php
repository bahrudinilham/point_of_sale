<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedTransaction extends Model
{
    protected $fillable = [
        'original_id',
        'invoice_number',
        'user_id',
        'total_amount',
        'final_amount',
        'cash_received',
        'change_amount',
        'payment_method_id',
        'transaction_date',
        'archived_at',
        'user_name',
        'payment_method_name',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(ArchivedTransactionItem::class);
    }

    /**
     * Try to get the original user, fallback to stored name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Try to get the original payment method, fallback to stored name
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the display name for the cashier
     */
    public function getCashierNameAttribute()
    {
        return $this->user?->name ?? $this->user_name ?? 'Unknown';
    }

    /**
     * Get the display name for the payment method
     */
    public function getPaymentMethodNameDisplayAttribute()
    {
        return $this->paymentMethod?->name ?? $this->payment_method_name ?? 'Unknown';
    }
}
