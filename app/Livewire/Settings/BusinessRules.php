<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class BusinessRules extends Component
{
    // Financial Settings
    public $default_currency;
    public $tax_rate;
    public $tax_name;
    public $tax_number;
    public $invoice_prefix;
    public $invoice_start_number;
    public $invoice_terms;
    public $payment_terms_days;
    
    // Order Management
    public $order_prefix;
    public $order_start_number;
    public $auto_order_approval;
    public $order_expiry_days;
    public $minimum_order_amount;
    public $allow_backorders;
    public $stock_reservation_minutes;
    
    // Inventory Settings
    public $low_stock_threshold;
    public $out_of_stock_threshold;
    public $auto_reorder_enabled;
    public $reorder_point_days;
    public $inventory_tracking_method;
    public $allow_negative_stock;
    
    // Customer Settings
    public $customer_prefix;
    public $customer_start_number;
    public $require_customer_approval;
    public $customer_credit_limit;
    public $loyalty_program_enabled;
    public $loyalty_points_rate;
    
    // Employee Settings
    public $employee_prefix;
    public $employee_start_number;
    public $default_work_hours_per_day;
    public $default_work_days_per_week;
    public $overtime_rate_multiplier;
    public $leave_accrual_rate;
    
    // Branch Operations
    public $enable_multi_branch;
    public $default_branch_id;
    public $inter_branch_transfers;
    public $branch_stock_sync;
    
    // Reporting
    public $fiscal_year_start;
    public $reporting_currency;
    public $decimal_places;
    public $show_zero_amounts;

    protected $rules = [
        'tax_rate' => 'required|numeric|min:0|max:100',
        'tax_name' => 'required|string|max:255',
        'invoice_prefix' => 'required|string|max:10',
        'invoice_start_number' => 'required|integer|min:1',
        'payment_terms_days' => 'required|integer|min:0|max:365',
        'order_prefix' => 'required|string|max:10',
        'order_start_number' => 'required|integer|min:1',
        'order_expiry_days' => 'required|integer|min:1|max:365',
        'minimum_order_amount' => 'required|numeric|min:0',
        'stock_reservation_minutes' => 'required|integer|min:1|max:1440',
        'low_stock_threshold' => 'required|integer|min:0',
        'out_of_stock_threshold' => 'required|integer|min:0',
        'reorder_point_days' => 'required|integer|min:1|max:365',
        'customer_prefix' => 'required|string|max:10',
        'customer_start_number' => 'required|integer|min:1',
        'customer_credit_limit' => 'required|numeric|min:0',
        'loyalty_points_rate' => 'required|numeric|min:0|max:100',
        'employee_prefix' => 'required|string|max:10',
        'employee_start_number' => 'required|integer|min:1',
        'default_work_hours_per_day' => 'required|numeric|min:1|max:24',
        'default_work_days_per_week' => 'required|integer|min:1|max:7',
        'overtime_rate_multiplier' => 'required|numeric|min:1|max:5',
        'leave_accrual_rate' => 'required|numeric|min:0|max:10',
        'fiscal_year_start' => 'required|integer|min:1|max:12',
        'decimal_places' => 'required|integer|min:0|max:4',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Financial Settings
        $this->default_currency = Setting::get('business.default_currency', 'USD');
        $this->tax_rate = Setting::get('business.tax_rate', 10.0);
        $this->tax_name = Setting::get('business.tax_name', 'VAT');
        $this->tax_number = Setting::get('business.tax_number', '');
        $this->invoice_prefix = Setting::get('business.invoice_prefix', 'INV');
        $this->invoice_start_number = Setting::get('business.invoice_start_number', 1000);
        $this->invoice_terms = Setting::get('business.invoice_terms', 'Payment due within 30 days');
        $this->payment_terms_days = Setting::get('business.payment_terms_days', 30);
        
        // Order Management
        $this->order_prefix = Setting::get('business.order_prefix', 'ORD');
        $this->order_start_number = Setting::get('business.order_start_number', 1000);
        $this->auto_order_approval = Setting::get('business.auto_order_approval', false);
        $this->order_expiry_days = Setting::get('business.order_expiry_days', 30);
        $this->minimum_order_amount = Setting::get('business.minimum_order_amount', 0);
        $this->allow_backorders = Setting::get('business.allow_backorders', true);
        $this->stock_reservation_minutes = Setting::get('business.stock_reservation_minutes', 30);
        
        // Inventory Settings
        $this->low_stock_threshold = Setting::get('business.low_stock_threshold', 10);
        $this->out_of_stock_threshold = Setting::get('business.out_of_stock_threshold', 0);
        $this->auto_reorder_enabled = Setting::get('business.auto_reorder_enabled', false);
        $this->reorder_point_days = Setting::get('business.reorder_point_days', 7);
        $this->inventory_tracking_method = Setting::get('business.inventory_tracking_method', 'fifo');
        $this->allow_negative_stock = Setting::get('business.allow_negative_stock', false);
        
        // Customer Settings
        $this->customer_prefix = Setting::get('business.customer_prefix', 'CUS');
        $this->customer_start_number = Setting::get('business.customer_start_number', 1000);
        $this->require_customer_approval = Setting::get('business.require_customer_approval', false);
        $this->customer_credit_limit = Setting::get('business.customer_credit_limit', 1000);
        $this->loyalty_program_enabled = Setting::get('business.loyalty_program_enabled', false);
        $this->loyalty_points_rate = Setting::get('business.loyalty_points_rate', 1.0);
        
        // Employee Settings
        $this->employee_prefix = Setting::get('business.employee_prefix', 'EMP');
        $this->employee_start_number = Setting::get('business.employee_start_number', 1000);
        $this->default_work_hours_per_day = Setting::get('business.default_work_hours_per_day', 8);
        $this->default_work_days_per_week = Setting::get('business.default_work_days_per_week', 5);
        $this->overtime_rate_multiplier = Setting::get('business.overtime_rate_multiplier', 1.5);
        $this->leave_accrual_rate = Setting::get('business.leave_accrual_rate', 1.75);
        
        // Branch Operations
        $this->enable_multi_branch = Setting::get('business.enable_multi_branch', true);
        $this->default_branch_id = Setting::get('business.default_branch_id', 1);
        $this->inter_branch_transfers = Setting::get('business.inter_branch_transfers', true);
        $this->branch_stock_sync = Setting::get('business.branch_stock_sync', false);
        
        // Reporting
        $this->fiscal_year_start = Setting::get('business.fiscal_year_start', 1);
        $this->reporting_currency = Setting::get('business.reporting_currency', 'USD');
        $this->decimal_places = Setting::get('business.decimal_places', 2);
        $this->show_zero_amounts = Setting::get('business.show_zero_amounts', false);
    }

    public function save()
    {
        $this->validate();

        try {
            // Save Financial Settings
            Setting::set('business.default_currency', $this->default_currency);
            Setting::set('business.tax_rate', $this->tax_rate);
            Setting::set('business.tax_name', $this->tax_name);
            Setting::set('business.tax_number', $this->tax_number);
            Setting::set('business.invoice_prefix', $this->invoice_prefix);
            Setting::set('business.invoice_start_number', $this->invoice_start_number);
            Setting::set('business.invoice_terms', $this->invoice_terms);
            Setting::set('business.payment_terms_days', $this->payment_terms_days);
            
            // Save Order Management
            Setting::set('business.order_prefix', $this->order_prefix);
            Setting::set('business.order_start_number', $this->order_start_number);
            Setting::set('business.auto_order_approval', $this->auto_order_approval);
            Setting::set('business.order_expiry_days', $this->order_expiry_days);
            Setting::set('business.minimum_order_amount', $this->minimum_order_amount);
            Setting::set('business.allow_backorders', $this->allow_backorders);
            Setting::set('business.stock_reservation_minutes', $this->stock_reservation_minutes);
            
            // Save Inventory Settings
            Setting::set('business.low_stock_threshold', $this->low_stock_threshold);
            Setting::set('business.out_of_stock_threshold', $this->out_of_stock_threshold);
            Setting::set('business.auto_reorder_enabled', $this->auto_reorder_enabled);
            Setting::set('business.reorder_point_days', $this->reorder_point_days);
            Setting::set('business.inventory_tracking_method', $this->inventory_tracking_method);
            Setting::set('business.allow_negative_stock', $this->allow_negative_stock);
            
            // Save Customer Settings
            Setting::set('business.customer_prefix', $this->customer_prefix);
            Setting::set('business.customer_start_number', $this->customer_start_number);
            Setting::set('business.require_customer_approval', $this->require_customer_approval);
            Setting::set('business.customer_credit_limit', $this->customer_credit_limit);
            Setting::set('business.loyalty_program_enabled', $this->loyalty_program_enabled);
            Setting::set('business.loyalty_points_rate', $this->loyalty_points_rate);
            
            // Save Employee Settings
            Setting::set('business.employee_prefix', $this->employee_prefix);
            Setting::set('business.employee_start_number', $this->employee_start_number);
            Setting::set('business.default_work_hours_per_day', $this->default_work_hours_per_day);
            Setting::set('business.default_work_days_per_week', $this->default_work_days_per_week);
            Setting::set('business.overtime_rate_multiplier', $this->overtime_rate_multiplier);
            Setting::set('business.leave_accrual_rate', $this->leave_accrual_rate);
            
            // Save Branch Operations
            Setting::set('business.enable_multi_branch', $this->enable_multi_branch);
            Setting::set('business.default_branch_id', $this->default_branch_id);
            Setting::set('business.inter_branch_transfers', $this->inter_branch_transfers);
            Setting::set('business.branch_stock_sync', $this->branch_stock_sync);
            
            // Save Reporting
            Setting::set('business.fiscal_year_start', $this->fiscal_year_start);
            Setting::set('business.reporting_currency', $this->reporting_currency);
            Setting::set('business.decimal_places', $this->decimal_places);
            Setting::set('business.show_zero_amounts', $this->show_zero_amounts);

            session()->flash('message', 'Business rules updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update business rules: ' . $e->getMessage());
        }
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

    public function getInventoryMethods()
    {
        return [
            'fifo' => 'First In, First Out (FIFO)',
            'lifo' => 'Last In, First Out (LIFO)',
            'weighted_average' => 'Weighted Average',
            'specific_identification' => 'Specific Identification',
        ];
    }

    public function getMonths()
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
    }

    public function render()
    {
        return view('livewire.settings.business-rules');
    }
}