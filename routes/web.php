<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Rute untuk Login & Logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// Rute untuk Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Halaman dashboard admin
    })->name('admin.dashboard');
});

// Dashboard Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/dashboard', function () {
        return view('kasir.dashboard'); // Halaman dashboard kasir
    })->name('kasir.dashboard');
});
