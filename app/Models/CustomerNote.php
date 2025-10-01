<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'note_type',
        'subject',
        'content',
        'is_private',
        'follow_up_date',
    ];

    protected $casts = [
        'follow_up_date' => 'datetime',
        'is_private' => 'boolean',
    ];

    public const TYPES = [
        'note' => 'Note',
        'call' => 'Phone Call',
        'email' => 'Email',
        'meeting' => 'Meeting',
        'complaint' => 'Complaint',
        'feedback' => 'Feedback',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }
}