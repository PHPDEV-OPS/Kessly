<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'mobile',
        'company',
        'website',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'tax_id',
        'customer_type',
        'status',
        'credit_limit',
        'payment_terms',
        'notes',
        'tags',
        'last_contact',
        'total_orders',
        'total_spent',
        'avatar',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'last_contact' => 'datetime',
        'tags' => 'array',
    ];

    public const TYPES = [
        'individual' => 'Individual',
        'business' => 'Business',
        'enterprise' => 'Enterprise',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'prospect' => 'Prospect',
        'blocked' => 'Blocked',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function customerNotes(): HasMany
    {
        return $this->hasMany(CustomerNote::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('customer_type', $type);
    }

    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->address) $address[] = $this->address;
        if ($this->city) $address[] = $this->city;
        if ($this->state) $address[] = $this->state;
        if ($this->postal_code) $address[] = $this->postal_code;
        if ($this->country) $address[] = $this->country;

        return implode(', ', $address);
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    public function getDisplayNameAttribute()
    {
        return $this->company ?: $this->name;
    }

    public function updateTotals()
    {
        $this->total_orders = $this->orders()->count();
        $this->total_spent = $this->orders()->sum('total_amount');
        $this->save();
    }
}
