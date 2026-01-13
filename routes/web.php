<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\SearchController;



// Volt Page Routes
Route::middleware(['auth'])->group(function () {
    Volt::route('/', 'pages/dashboard')->name('dashboard');
    Volt::route('/inventory', 'pages/inventory')->name('inventory');
    Volt::route('/sales', 'pages/sales')->name('sales');
    Volt::route('/reports', 'pages/reports')->name('reports');
    Volt::route('/settings', 'pages/settings')->name('settings');
    Volt::route('/profile', 'pages/profile')->name('profile');
    
    // Global Search
    Route::get('/search', [SearchController::class, 'globalSearch'])->name('search');
    
    // HR Module Routes
    Volt::route('/hr', 'pages/hr')->name('hr');
    
    // Branches Module Routes
    Volt::route('/branches', 'pages/branches')->name('branches');
    
    // Finance Module Routes
    Volt::route('/finance', 'pages/finance')->name('finance');
    
    // Customers Module Routes
    Volt::route('/customers', 'pages/customers')->name('customers');
    
    // Orders Route
    Volt::route('/orders', 'pages/sales')->name('orders');
    
    // Invoices Route
    Volt::route('/invoices', 'pages/sales')->name('invoices');
    
    // Employees Route
    Volt::route('/employees', 'pages/hr')->name('employees');
    
    // Analytics Module Routes
    Volt::route('/analytics', 'pages/analytics')->name('analytics');
});





require __DIR__.'/auth.php';
