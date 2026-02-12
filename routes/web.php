<?php

use App\Http\Controllers\PesapalController;
use App\Http\Controllers\EmailTrackingController;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;

require __DIR__.'/auth.php'; // login, register, reset-password

// Email tracking routes (public)
Route::get('/email/track/{trackingId}', [EmailTrackingController::class, 'track'])->name('email.track');
Route::post('/pesapal/pay', [PesapalController::class, 'pay'])->name('pesapal.pay');
Route::match(['get', 'post'], '/pesapal/callback', [PesapalController::class, 'callback'])->name('pesapal.callback');

// Protected pages
Route::middleware(['auth'])->group(function () {
    // Basic Access (Business Management) - Accessible to all authenticated users
    Volt::route('/', 'pages/dashboard')->name('dashboard');
    Volt::route('/inventory', 'pages/inventory')->name('inventory');
    Volt::route('/sales', 'pages/sales')->name('sales');
    Volt::route('/reports', 'pages/reports')->name('reports');
    Volt::route('/customers', 'pages/customers')->name('customers');
    Volt::route('/orders', 'pages/sales')->name('orders');
    Volt::route('/invoices', 'pages/sales')->name('invoices');
    Volt::route('/pos', 'pages/pos')->name('pos');
    Volt::route('/profile', 'pages/profile')->name('profile');

    // Global Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'globalSearch'])->name('search');

    // HR & Operations (HR Manager, Branch Manager, Accountant, Admin)
    Route::middleware(['check_role:HR Manager,Branch Manager,Accountant'])->group(function () {
        Volt::route('/hr', 'pages/hr')->name('hr');
        Volt::route('/employees', 'pages/hr')->name('employees');
        Volt::route('/branches', 'pages/branches')->name('branches');
    });

    // Finance & Analytics (Accountant, Branch Manager, Admin)
    Route::middleware(['check_role:Accountant,Branch Manager'])->group(function () {
        Volt::route('/finance', 'pages/finance')->name('finance');
        Volt::route('/analytics', 'pages/analytics')->name('analytics');
    });

    // Settings (Admin only)
    Route::middleware(['check_role:Administrator,Super Admin'])->group(function () {
        Volt::route('/settings', 'pages/settings')->name('settings');
    });
});
