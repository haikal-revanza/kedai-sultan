<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\OrderController;

// Rute untuk Login & Logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// Logout hanya untuk pengguna yang sudah login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('menus', MenuController::class)->except('show');
    Route::get('menus/{menu}/download', [MenuController::class, 'downloadImage'])->name('menus.download');
});

// Dashboard Kasir
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('dashboard', function () {
        return view('kasir.dashboard');
    })->name('dashboard');
});

// Rute untuk pelanggan (tanpa login)
Route::get('/menus', [OrderController::class, 'showMenus'])->name('menus.index');
Route::post('/order', [OrderController::class, 'storeOrder'])->name('order.store'); // Menambahkan rute POST untuk menyimpan pesanan
Route::get('/order/edit', [OrderController::class, 'editOrder'])->name('order.edit');
Route::post('/order/update', [OrderController::class, 'updateOrder'])->name('order.update');

Route::post('/order/delete', [OrderController::class, 'deleteOrderItem'])->name('order.delete');
