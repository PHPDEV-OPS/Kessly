<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RoleBasedAccess;

class BranchInventory extends Model
{
    use HasFactory, RoleBasedAccess;

    protected $table = 'branch_inventory';

    protected $fillable = [
        'branch_id',
        'product_id',
        'quantity',
        'min_stock_level',
        'max_stock_level',
        'last_restocked',
        'notes',
    ];

    protected $casts = [
        'last_restocked' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function needsRestock()
    {
        return $this->quantity <= $this->min_stock_level;
    }

    public function isOverstocked()
    {
        return $this->quantity >= $this->max_stock_level;
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_stock_level');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }
}