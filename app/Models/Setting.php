<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, $default = null)
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get the company logo URL with fallback to default
     */
    public static function getCompanyLogo(): string
    {
        $profile = static::get('company.profile', []);
        $logoPath = $profile['logo'] ?? null;
        
        if ($logoPath && file_exists(storage_path('app/public/' . $logoPath))) {
            return asset('storage/' . $logoPath);
        }
        
        // Return null to indicate no logo available - let components handle the fallback
        return '';
    }

    /**
     * Get the company background image URL with fallback
     */
    public static function getCompanyBackgroundImage(): string
    {
        $profile = static::get('company.profile', []);
        $backgroundImagePath = $profile['background_image'] ?? null;
        
        if ($backgroundImagePath && file_exists(storage_path('app/public/' . $backgroundImagePath))) {
            return asset('storage/' . $backgroundImagePath);
        }
        
        // Return empty string to indicate no background image available
        return '';
    }

    /**
     * Get company name with fallback
     */
    public static function getCompanyName(): string
    {
        $profile = static::get('company.profile', []);
        return $profile['name'] ?? 'Kessly';
    }
}
