<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\MenuController;

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
