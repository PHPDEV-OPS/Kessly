<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;



// Volt Page Routes
Route::middleware(['auth'])->group(function () {
    Volt::route('/', 'pages/dashboard')->name('dashboard');
    Volt::route('/inventory', 'pages/inventory')->name('inventory');
    Volt::route('/sales', 'pages/sales')->name('sales');
    Volt::route('/reports', 'pages/reports')->name('reports');
    Volt::route('/settings', 'pages/settings')->name('settings');
    Volt::route('/profile', 'pages/profile')->name('profile');
    
    // HR Module Routes
    Volt::route('/hr', 'pages/hr')->name('hr');
    
    // Branches Module Routes
    Volt::route('/branches', 'pages/branches')->name('branches');
    
    // Finance Module Routes
    Volt::route('/finance', 'pages/finance')->name('finance');
    
    // Customers Module Routes
    Volt::route('/customers', 'pages/customers')->name('customers');
    
    // Analytics Module Routes
    Volt::route('/analytics', 'pages/analytics')->name('analytics');
});





require __DIR__.'/auth.php';
