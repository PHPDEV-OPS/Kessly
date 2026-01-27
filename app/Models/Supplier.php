<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\RoleBasedAccess;

class Supplier extends Model
{
    use HasFactory, RoleBasedAccess;

    protected $fillable = [
        'name',
        'contact_email',
        'phone',
        'address',
        'notes',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
