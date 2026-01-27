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
Route::get('/pesapal/callback', [PesapalController::class, 'callback'])->name('pesapal.callback');

// Protected pages
Route::middleware(['auth'])->group(function () {
    Volt::route('/', 'pages/dashboard')->name('dashboard');
    Volt::route('/inventory', 'pages/inventory')->name('inventory');
    Volt::route('/sales', 'pages/sales')->name('sales');
    Volt::route('/reports', 'pages/reports')->name('reports');
    Volt::route('/settings', 'pages/settings')->name('settings');
    Volt::route('/profile', 'pages/profile')->name('profile');

    // Global Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'globalSearch'])->name('search');

    // HR, Branches, Finance, Customers, Orders, Invoices, Employees, Analytics, POS
    Volt::route('/hr', 'pages/hr')->name('hr');
    Volt::route('/branches', 'pages/branches')->name('branches');
    Volt::route('/finance', 'pages/finance')->name('finance');
    Volt::route('/customers', 'pages/customers')->name('customers');
    Volt::route('/orders', 'pages/sales')->name('orders');
    Volt::route('/invoices', 'pages/sales')->name('invoices');
    Volt::route('/employees', 'pages/hr')->name('employees');
    Volt::route('/analytics', 'pages/analytics')->name('analytics');
    Volt::route('/pos', 'pages/pos')->name('pos');
});
