<?php

use Illuminate\Support\Facades\Route;
use livewire\Volt\Volt;



// Volt Page Routes
Route::middleware(['auth'])->group(function () {
    Volt::route('/', 'pages/dashboard')->name('dashboard');
    Volt::route('/inventory', 'pages/inventory');
    Volt::route('/sales', 'pages/sales');
    Volt::route('/reports', 'pages/reports');
    Volt::route('/settings', 'pages/settings');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
