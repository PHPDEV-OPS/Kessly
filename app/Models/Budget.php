<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'branch_id',
        'allocated_amount',
        'spent_amount',
        'period_start',
        'period_end',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'approved_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->allocated_amount - $this->spent_amount;
    }

    public function getUtilizationPercentageAttribute()
    {
        if ($this->allocated_amount == 0) return 0;
        return round(($this->spent_amount / $this->allocated_amount) * 100, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
                    ->where('period_start', '<=', now())
                    ->where('period_end', '>=', now());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}