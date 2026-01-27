<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailTracking extends Model
{
    protected $fillable = [
        'email_type',
        'recipient_email',
        'user_id',
        'tracking_id',
        'opened',
        'opened_at',
        'user_agent',
        'ip_address',
        'metadata',
    ];

    protected $casts = [
        'opened' => 'boolean',
        'opened_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the email tracking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique tracking ID
     */
    public static function generateTrackingId(): string
    {
        do {
            $trackingId = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 16));
        } while (self::where('tracking_id', $trackingId)->exists());

        return $trackingId;
    }

    /**
     * Record email open event
     */
    public function recordOpen(string $userAgent = null, string $ipAddress = null): bool
    {
        if ($this->opened) {
            return false; // Already recorded
        }

        return $this->update([
            'opened' => true,
            'opened_at' => now(),
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
        ]);
    }

    /**
     * Get open rate for email type
     */
    public static function getOpenRate(string $emailType): float
    {
        $total = self::where('email_type', $emailType)->count();
        if ($total === 0) return 0.0;

        $opened = self::where('email_type', $emailType)->where('opened', true)->count();
        return round(($opened / $total) * 100, 2);
    }

    /**
     * Get tracking statistics
     */
    public static function getStats(string $emailType = null): array
    {
        $query = self::query();

        if ($emailType) {
            $query->where('email_type', $emailType);
        }

        $total = $query->count();
        $opened = (clone $query)->where('opened', true)->count();
        $openRate = $total > 0 ? round(($opened / $total) * 100, 2) : 0;

        return [
            'total_sent' => $total,
            'total_opened' => $opened,
            'open_rate' => $openRate,
            'last_24h' => (clone $query)->where('created_at', '>=', now()->subDay())->count(),
            'opened_last_24h' => (clone $query)->where('opened', true)->where('opened_at', '>=', now()->subDay())->count(),
        ];
    }
}
