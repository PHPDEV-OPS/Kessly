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
});





require __DIR__.'/auth.php';
