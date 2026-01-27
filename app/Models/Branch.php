<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RoleBasedAccess;

class Branch extends Model
{
    use HasFactory, RoleBasedAccess;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'email',
        'manager_id',
        'status',
        'established_date',
        'description',
    ];

    protected $casts = [
        'established_date' => 'date',
    ];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function inventory()
    {
        return $this->hasMany(BranchInventory::class);
    }

    public function getFullAddressAttribute()
    {
        return trim("{$this->address}, {$this->city}, {$this->state} {$this->postal_code}");
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}