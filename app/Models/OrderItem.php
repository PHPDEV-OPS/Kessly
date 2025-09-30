<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that belongs to the order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total price based on quantity and unit price.
     */
    public function calculateTotalPrice(): void
    {
        $this->total_price = $this->quantity * $this->unit_price;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($orderItem) {
            if (!$orderItem->total_price) {
                $orderItem->calculateTotalPrice();
            }
        });

        static::updating(function ($orderItem) {
            if ($orderItem->isDirty(['quantity', 'unit_price'])) {
                $orderItem->calculateTotalPrice();
            }
        });
    }
}