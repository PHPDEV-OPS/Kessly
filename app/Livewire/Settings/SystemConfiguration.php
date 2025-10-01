<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Carbon\Carbon;

class SystemConfiguration extends Component
{
    // Application Settings
    public $app_name;
    public $app_url;
    public $app_debug;
    public $app_env;
    
    // Localization Settings
    public $timezone;
    public $locale;
    public $currency;
    public $date_format;
    public $time_format;
    public $decimal_separator;
    public $thousands_separator;
    public $currency_position;
    
    // System Preferences
    public $maintenance_mode;
    public $cache_enabled;
    public $session_lifetime;
    public $max_login_attempts;
    public $lockout_duration;

    protected $rules = [
        'app_name' => 'required|string|max:255',
        'app_url' => 'required|url',
        'timezone' => 'required|string',
        'locale' => 'required|string',
        'currency' => 'required|string|max:3',
        'date_format' => 'required|string',
        'time_format' => 'required|string',
        'decimal_separator' => 'required|string|max:1',
        'thousands_separator' => 'required|string|max:1',
        'currency_position' => 'required|string|in:before,after',
        'session_lifetime' => 'required|integer|min:1|max:10080',
        'max_login_attempts' => 'required|integer|min:1|max:20',
        'lockout_duration' => 'required|integer|min:1|max:1440',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Application Settings
        $this->app_name = Setting::get('app_name', config('app.name'));
        $this->app_url = Setting::get('app_url', config('app.url'));
        $this->app_debug = Setting::get('app_debug', config('app.debug'));
        $this->app_env = Setting::get('app_env', config('app.env'));
        
        // Localization Settings
        $this->timezone = Setting::get('timezone', config('app.timezone'));
        $this->locale = Setting::get('locale', config('app.locale'));
        $this->currency = Setting::get('currency', 'KES');
        $this->date_format = Setting::get('date_format', 'Y-m-d');
        $this->time_format = Setting::get('time_format', 'H:i:s');
        $this->decimal_separator = Setting::get('decimal_separator', '.');
        $this->thousands_separator = Setting::get('thousands_separator', ',');
        $this->currency_position = Setting::get('currency_position', 'before');
        
        // System Preferences
        $this->maintenance_mode = Setting::get('maintenance_mode', false);
        $this->cache_enabled = Setting::get('cache_enabled', true);
        $this->session_lifetime = Setting::get('session_lifetime', 120);
        $this->max_login_attempts = Setting::get('max_login_attempts', 5);
        $this->lockout_duration = Setting::get('lockout_duration', 15);
    }

    public function save()
    {
        $this->validate();

        try {
            // Save Application Settings
            Setting::set('app_name', $this->app_name);
            Setting::set('app_url', $this->app_url);
            Setting::set('app_debug', $this->app_debug);
            Setting::set('app_env', $this->app_env);
            
            // Save Localization Settings
            Setting::set('timezone', $this->timezone);
            Setting::set('locale', $this->locale);
            Setting::set('currency', $this->currency);
            Setting::set('date_format', $this->date_format);
            Setting::set('time_format', $this->time_format);
            Setting::set('decimal_separator', $this->decimal_separator);
            Setting::set('thousands_separator', $this->thousands_separator);
            Setting::set('currency_position', $this->currency_position);
            
            // Save System Preferences
            Setting::set('maintenance_mode', $this->maintenance_mode);
            Setting::set('cache_enabled', $this->cache_enabled);
            Setting::set('session_lifetime', $this->session_lifetime);
            Setting::set('max_login_attempts', $this->max_login_attempts);
            Setting::set('lockout_duration', $this->lockout_duration);

            session()->flash('message', 'System configuration updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update system configuration: ' . $e->getMessage());
        }
    }

    public function resetToDefaults()
    {
        $this->app_name = config('app.name');
        $this->app_url = config('app.url');
        $this->app_debug = config('app.debug');
        $this->app_env = config('app.env');
        $this->timezone = config('app.timezone');
        $this->locale = config('app.locale');
        $this->currency = 'USD';
        $this->date_format = 'Y-m-d';
        $this->time_format = 'H:i:s';
        $this->decimal_separator = '.';
        $this->thousands_separator = ',';
        $this->currency_position = 'before';
        $this->maintenance_mode = false;
        $this->cache_enabled = true;
        $this->session_lifetime = 120;
        $this->max_login_attempts = 5;
        $this->lockout_duration = 15;

        session()->flash('message', 'Settings reset to default values.');
    }

    public function getTimezones()
    {
        return collect(timezone_identifiers_list())
            ->mapWithKeys(fn($tz) => [$tz => $tz])
            ->toArray();
    }

    public function getLocales()
    {
        return [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ja' => 'Japanese',
            'zh' => 'Chinese',
        ];
    }

    public function getCurrencies()
    {
        return [
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'JPY' => 'Japanese Yen (¥)',
            'CAD' => 'Canadian Dollar (C$)',
            'AUD' => 'Australian Dollar (A$)',
            'CHF' => 'Swiss Franc (CHF)',
            'CNY' => 'Chinese Yuan (¥)',
            'INR' => 'Indian Rupee (₹)',
            'BRL' => 'Brazilian Real (R$)',
        ];
    }

    public function getDateFormats()
    {
        return [
            'Y-m-d' => 'YYYY-MM-DD (2025-01-01)',
            'm/d/Y' => 'MM/DD/YYYY (01/01/2025)',
            'd/m/Y' => 'DD/MM/YYYY (01/01/2025)',
            'd-m-Y' => 'DD-MM-YYYY (01-01-2025)',
            'F j, Y' => 'Month Day, Year (January 1, 2025)',
            'j F Y' => 'Day Month Year (1 January 2025)',
        ];
    }

    public function getTimeFormats()
    {
        return [
            'H:i:s' => '24-hour (14:30:00)',
            'H:i' => '24-hour short (14:30)',
            'g:i:s A' => '12-hour (2:30:00 PM)',
            'g:i A' => '12-hour short (2:30 PM)',
        ];
    }

    public function render()
    {
        return view('livewire.settings.system-configuration');
    }
}