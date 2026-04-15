<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Go straight to dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

// Dashboard + app routes — no auth required
Route::group([], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('rice', RiceController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class);
});

require __DIR__.'/auth.php';