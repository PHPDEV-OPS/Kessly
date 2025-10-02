<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class SecuritySettings extends Component
{
    // Authentication Settings
    public $password_min_length;
    public $password_require_uppercase;
    public $password_require_lowercase;
    public $password_require_numbers;
    public $password_require_symbols;
    public $password_expiry_days;
    public $password_history_limit;
    
    // Session Settings
    public $session_timeout;
    public $concurrent_sessions;
    public $remember_me_enabled;
    public $remember_me_duration;
    
    // Security Features
    public $two_factor_required;
    public $email_verification_required;
    public $ip_whitelist_enabled;
    public $allowed_ips;
    public $login_notification_enabled;
    public $suspicious_activity_detection;
    
    // Account Lockout
    public $account_lockout_enabled;
    public $max_failed_attempts;
    public $lockout_duration_minutes;
    public $reset_failed_attempts_after;
    
    // API Security
    public $api_rate_limit_enabled;
    public $api_requests_per_minute;
    public $api_key_expiry_days;
    public $cors_enabled;
    public $allowed_origins;

    protected $rules = [
        'password_min_length' => 'required|integer|min:6|max:128',
        'password_expiry_days' => 'nullable|integer|min:1|max:365',
        'password_history_limit' => 'nullable|integer|min:0|max:24',
        'session_timeout' => 'required|integer|min:5|max:1440',
        'concurrent_sessions' => 'required|integer|min:1|max:10',
        'remember_me_duration' => 'required|integer|min:1|max:365',
        'allowed_ips' => 'nullable|string',
        'max_failed_attempts' => 'required|integer|min:1|max:20',
        'lockout_duration_minutes' => 'required|integer|min:1|max:1440',
        'reset_failed_attempts_after' => 'required|integer|min:1|max:1440',
        'api_requests_per_minute' => 'required|integer|min:1|max:10000',
        'api_key_expiry_days' => 'required|integer|min:1|max:365',
        'allowed_origins' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Authentication Settings
        $this->password_min_length = Setting::get('security.password_min_length', 8);
        $this->password_require_uppercase = Setting::get('security.password_require_uppercase', true);
        $this->password_require_lowercase = Setting::get('security.password_require_lowercase', true);
        $this->password_require_numbers = Setting::get('security.password_require_numbers', true);
        $this->password_require_symbols = Setting::get('security.password_require_symbols', false);
        $this->password_expiry_days = Setting::get('security.password_expiry_days', null);
        $this->password_history_limit = Setting::get('security.password_history_limit', 5);
        
        // Session Settings
        $this->session_timeout = Setting::get('security.session_timeout', 120);
        $this->concurrent_sessions = Setting::get('security.concurrent_sessions', 3);
        $this->remember_me_enabled = Setting::get('security.remember_me_enabled', true);
        $this->remember_me_duration = Setting::get('security.remember_me_duration', 30);
        
        // Security Features
        $this->two_factor_required = Setting::get('security.two_factor_required', false);
        $this->email_verification_required = Setting::get('security.email_verification_required', true);
        $this->ip_whitelist_enabled = Setting::get('security.ip_whitelist_enabled', false);
        $this->allowed_ips = Setting::get('security.allowed_ips', '');
        $this->login_notification_enabled = Setting::get('security.login_notification_enabled', false);
        $this->suspicious_activity_detection = Setting::get('security.suspicious_activity_detection', false);
        
        // Account Lockout
        $this->account_lockout_enabled = Setting::get('security.account_lockout_enabled', true);
        $this->max_failed_attempts = Setting::get('security.max_failed_attempts', 5);
        $this->lockout_duration_minutes = Setting::get('security.lockout_duration_minutes', 15);
        $this->reset_failed_attempts_after = Setting::get('security.reset_failed_attempts_after', 60);
        
        // API Security
        $this->api_rate_limit_enabled = Setting::get('security.api_rate_limit_enabled', true);
        $this->api_requests_per_minute = Setting::get('security.api_requests_per_minute', 60);
        $this->api_key_expiry_days = Setting::get('security.api_key_expiry_days', 90);
        $this->cors_enabled = Setting::get('security.cors_enabled', true);
        $this->allowed_origins = Setting::get('security.allowed_origins', '*');
    }

    public function save()
    {
        $this->validate();

        try {
            // Save Authentication Settings
            Setting::set('security.password_min_length', $this->password_min_length);
            Setting::set('security.password_require_uppercase', $this->password_require_uppercase);
            Setting::set('security.password_require_lowercase', $this->password_require_lowercase);
            Setting::set('security.password_require_numbers', $this->password_require_numbers);
            Setting::set('security.password_require_symbols', $this->password_require_symbols);
            Setting::set('security.password_expiry_days', $this->password_expiry_days);
            Setting::set('security.password_history_limit', $this->password_history_limit);
            
            // Save Session Settings
            Setting::set('security.session_timeout', $this->session_timeout);
            Setting::set('security.concurrent_sessions', $this->concurrent_sessions);
            Setting::set('security.remember_me_enabled', $this->remember_me_enabled);
            Setting::set('security.remember_me_duration', $this->remember_me_duration);
            
            // Save Security Features
            Setting::set('security.two_factor_required', $this->two_factor_required);
            Setting::set('security.email_verification_required', $this->email_verification_required);
            Setting::set('security.ip_whitelist_enabled', $this->ip_whitelist_enabled);
            Setting::set('security.allowed_ips', $this->allowed_ips);
            Setting::set('security.login_notification_enabled', $this->login_notification_enabled);
            Setting::set('security.suspicious_activity_detection', $this->suspicious_activity_detection);
            
            // Save Account Lockout
            Setting::set('security.account_lockout_enabled', $this->account_lockout_enabled);
            Setting::set('security.max_failed_attempts', $this->max_failed_attempts);
            Setting::set('security.lockout_duration_minutes', $this->lockout_duration_minutes);
            Setting::set('security.reset_failed_attempts_after', $this->reset_failed_attempts_after);
            
            // Save API Security
            Setting::set('security.api_rate_limit_enabled', $this->api_rate_limit_enabled);
            Setting::set('security.api_requests_per_minute', $this->api_requests_per_minute);
            Setting::set('security.api_key_expiry_days', $this->api_key_expiry_days);
            Setting::set('security.cors_enabled', $this->cors_enabled);
            Setting::set('security.allowed_origins', $this->allowed_origins);

            session()->flash('message', 'Security settings updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update security settings: ' . $e->getMessage());
        }
    }

    public function resetToDefaults()
    {
        $this->password_min_length = 8;
        $this->password_require_uppercase = true;
        $this->password_require_lowercase = true;
        $this->password_require_numbers = true;
        $this->password_require_symbols = false;
        $this->password_expiry_days = null;
        $this->password_history_limit = 5;
        
        $this->session_timeout = 120;
        $this->concurrent_sessions = 3;
        $this->remember_me_enabled = true;
        $this->remember_me_duration = 30;
        
        $this->two_factor_required = false;
        $this->email_verification_required = true;
        $this->ip_whitelist_enabled = false;
        $this->allowed_ips = '';
        $this->login_notification_enabled = true;
        $this->suspicious_activity_detection = true;
        
        $this->account_lockout_enabled = true;
        $this->max_failed_attempts = 5;
        $this->lockout_duration_minutes = 15;
        $this->reset_failed_attempts_after = 60;
        
        $this->api_rate_limit_enabled = true;
        $this->api_requests_per_minute = 60;
        $this->api_key_expiry_days = 90;
        $this->cors_enabled = true;
        $this->allowed_origins = '*';

        session()->flash('message', 'Security settings reset to default values.');
    }

    public function render()
    {
        return view('livewire.settings.security-settings');
    }
}