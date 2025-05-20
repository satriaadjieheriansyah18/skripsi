<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminAuthController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [AdminOrderController::class, 'index'])->name('admin.dashboard');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/fetch-orders', [AdminOrderController::class, 'fetchOrders'])->name('admin.fetchOrders');
});

