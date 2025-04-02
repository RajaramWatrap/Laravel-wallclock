<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [MainController::class, 'index'])->name('main');

Route::resource('carts', CartController::class)->only(['index']);
Route::post('/carts/start-order', [CartController::class, 'startOrder'])->name('carts.startOrder');

Route::resource('orders', OrderController::class)->only(['create', 'store']);
Route::resource('products.carts', ProductCartController::class)->only(['store', 'destroy']);
Route::resource('orders.payments', OrderPaymentController::class)->only(['create', 'store']);

// ❌ Removed Sales Reports (Moved to `panel.php`)

// Authentication Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Ensure admin panel routes are loaded
require base_path('routes/panel.php');
