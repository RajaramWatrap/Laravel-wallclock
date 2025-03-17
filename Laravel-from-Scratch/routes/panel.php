<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ProductController;

// ✅ Admin Panel Routes
Route::middleware(['auth'])->prefix('panel')->name('panel.')->group(function () {
    Route::resource('products', ProductController::class);
});
