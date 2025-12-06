<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedTransactionItem extends Model
{
    protected $fillable = [
        'original_id',
        'archived_transaction_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'note',
        'product_name',
    ];

    public function archivedTransaction()
    {
        return $this->belongsTo(ArchivedTransaction::class);
    }

    /**
     * Try to get the original product, fallback to stored name
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the display name for the product
     */
    public function getProductNameDisplayAttribute()
    {
        return $this->product?->name ?? $this->product_name ?? 'Unknown Product';
    }
}
