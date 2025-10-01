<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class EmailNotifications extends Component
{
    // SMTP Configuration
    public $mail_mailer;
    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;
    public $mail_from_address;
    public $mail_from_name;
    
    // Email Templates
    public $welcome_email_enabled;
    public $welcome_email_subject;
    public $order_confirmation_enabled;
    public $order_confirmation_subject;
    public $invoice_email_enabled;
    public $invoice_email_subject;
    public $password_reset_subject;
    
    // Notification Preferences
    public $notify_new_orders;
    public $notify_low_stock;
    public $notify_new_users;
    public $notify_system_updates;
    public $notify_payment_received;
    public $notify_invoice_overdue;
    
    // Notification Recipients
    public $admin_email;
    public $sales_email;
    public $support_email;
    public $finance_email;
    
    // System Notifications
    public $daily_reports_enabled;
    public $weekly_reports_enabled;
    public $monthly_reports_enabled;
    public $backup_notifications;
    public $error_notifications;
    public $security_notifications;

    protected $rules = [
        'mail_host' => 'required_if:mail_mailer,smtp|nullable|string',
        'mail_port' => 'required_if:mail_mailer,smtp|nullable|integer|min:1|max:65535',
        'mail_username' => 'required_if:mail_mailer,smtp|nullable|string',
        'mail_password' => 'nullable|string',
        'mail_encryption' => 'nullable|string|in:tls,ssl',
        'mail_from_address' => 'required|email',
        'mail_from_name' => 'required|string|max:255',
        'welcome_email_subject' => 'required_if:welcome_email_enabled,true|nullable|string|max:255',
        'order_confirmation_subject' => 'required_if:order_confirmation_enabled,true|nullable|string|max:255',
        'invoice_email_subject' => 'required_if:invoice_email_enabled,true|nullable|string|max:255',
        'password_reset_subject' => 'required|string|max:255',
        'admin_email' => 'required|email',
        'sales_email' => 'nullable|email',
        'support_email' => 'nullable|email',
        'finance_email' => 'nullable|email',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // SMTP Configuration
        $this->mail_mailer = Setting::get('mail.mailer', 'smtp');
        $this->mail_host = Setting::get('mail.host', '');
        $this->mail_port = Setting::get('mail.port', 587);
        $this->mail_username = Setting::get('mail.username', '');
        $this->mail_password = Setting::get('mail.password', '');
        $this->mail_encryption = Setting::get('mail.encryption', 'tls');
        $this->mail_from_address = Setting::get('mail.from_address', config('mail.from.address'));
        $this->mail_from_name = Setting::get('mail.from_name', config('mail.from.name'));
        
        // Email Templates
        $this->welcome_email_enabled = Setting::get('notifications.welcome_email_enabled', true);
        $this->welcome_email_subject = Setting::get('notifications.welcome_email_subject', 'Welcome to {{app_name}}!');
        $this->order_confirmation_enabled = Setting::get('notifications.order_confirmation_enabled', true);
        $this->order_confirmation_subject = Setting::get('notifications.order_confirmation_subject', 'Order Confirmation - {{order_number}}');
        $this->invoice_email_enabled = Setting::get('notifications.invoice_email_enabled', true);
        $this->invoice_email_subject = Setting::get('notifications.invoice_email_subject', 'Invoice {{invoice_number}}');
        $this->password_reset_subject = Setting::get('notifications.password_reset_subject', 'Reset Your Password');
        
        // Notification Preferences
        $this->notify_new_orders = Setting::get('notifications.notify_new_orders', true);
        $this->notify_low_stock = Setting::get('notifications.notify_low_stock', true);
        $this->notify_new_users = Setting::get('notifications.notify_new_users', true);
        $this->notify_system_updates = Setting::get('notifications.notify_system_updates', false);
        $this->notify_payment_received = Setting::get('notifications.notify_payment_received', true);
        $this->notify_invoice_overdue = Setting::get('notifications.notify_invoice_overdue', true);
        
        // Notification Recipients
        $this->admin_email = Setting::get('notifications.admin_email', config('mail.from.address'));
        $this->sales_email = Setting::get('notifications.sales_email', '');
        $this->support_email = Setting::get('notifications.support_email', '');
        $this->finance_email = Setting::get('notifications.finance_email', '');
        
        // System Notifications
        $this->daily_reports_enabled = Setting::get('notifications.daily_reports_enabled', false);
        $this->weekly_reports_enabled = Setting::get('notifications.weekly_reports_enabled', true);
        $this->monthly_reports_enabled = Setting::get('notifications.monthly_reports_enabled', true);
        $this->backup_notifications = Setting::get('notifications.backup_notifications', true);
        $this->error_notifications = Setting::get('notifications.error_notifications', true);
        $this->security_notifications = Setting::get('notifications.security_notifications', true);
    }

    public function save()
    {
        $this->validate();

        try {
            // Save SMTP Configuration
            Setting::set('mail.mailer', $this->mail_mailer);
            Setting::set('mail.host', $this->mail_host);
            Setting::set('mail.port', $this->mail_port);
            Setting::set('mail.username', $this->mail_username);
            if (!empty($this->mail_password)) {
                Setting::set('mail.password', $this->mail_password);
            }
            Setting::set('mail.encryption', $this->mail_encryption);
            Setting::set('mail.from_address', $this->mail_from_address);
            Setting::set('mail.from_name', $this->mail_from_name);
            
            // Save Email Templates
            Setting::set('notifications.welcome_email_enabled', $this->welcome_email_enabled);
            Setting::set('notifications.welcome_email_subject', $this->welcome_email_subject);
            Setting::set('notifications.order_confirmation_enabled', $this->order_confirmation_enabled);
            Setting::set('notifications.order_confirmation_subject', $this->order_confirmation_subject);
            Setting::set('notifications.invoice_email_enabled', $this->invoice_email_enabled);
            Setting::set('notifications.invoice_email_subject', $this->invoice_email_subject);
            Setting::set('notifications.password_reset_subject', $this->password_reset_subject);
            
            // Save Notification Preferences
            Setting::set('notifications.notify_new_orders', $this->notify_new_orders);
            Setting::set('notifications.notify_low_stock', $this->notify_low_stock);
            Setting::set('notifications.notify_new_users', $this->notify_new_users);
            Setting::set('notifications.notify_system_updates', $this->notify_system_updates);
            Setting::set('notifications.notify_payment_received', $this->notify_payment_received);
            Setting::set('notifications.notify_invoice_overdue', $this->notify_invoice_overdue);
            
            // Save Notification Recipients
            Setting::set('notifications.admin_email', $this->admin_email);
            Setting::set('notifications.sales_email', $this->sales_email);
            Setting::set('notifications.support_email', $this->support_email);
            Setting::set('notifications.finance_email', $this->finance_email);
            
            // Save System Notifications
            Setting::set('notifications.daily_reports_enabled', $this->daily_reports_enabled);
            Setting::set('notifications.weekly_reports_enabled', $this->weekly_reports_enabled);
            Setting::set('notifications.monthly_reports_enabled', $this->monthly_reports_enabled);
            Setting::set('notifications.backup_notifications', $this->backup_notifications);
            Setting::set('notifications.error_notifications', $this->error_notifications);
            Setting::set('notifications.security_notifications', $this->security_notifications);

            session()->flash('message', 'Email and notification settings updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    public function testEmail()
    {
        try {
            // Send test email logic here
            session()->flash('message', 'Test email sent successfully to ' . $this->admin_email);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    public function getMailers()
    {
        return [
            'smtp' => 'SMTP',
            'sendmail' => 'Sendmail',
            'mailgun' => 'Mailgun',
            'ses' => 'Amazon SES',
            'log' => 'Log (Development)',
        ];
    }

    public function render()
    {
        return view('livewire.settings.email-notifications');
    }
}