<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\SalesReportController;
use App\Http\Middleware\CheckIfAdmin;

Route::middleware(['auth', CheckIfAdmin::class])
    ->prefix('panel')
    ->name('panel.')
    ->group(function () {
        Route::get('/', [PanelController::class, 'index'])->name('index'); // Admin Panel Dashboard
        Route::resource('products', ProductController::class);

        // ✅ Admin-only Sales Reports
        Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');
    });
