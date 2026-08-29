<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PengaduanController;

// Beranda langsung diarahkan ke halaman login
Route::redirect('/', '/login');

// ===== ROUTE AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');

// ===== ROUTE WAJIB LOGIN =====
Route::middleware('auth')->group(function () {

    // Logout wajib POST agar lebih aman
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route perantara: /dashboard melempar ke dashboard sesuai role
    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->role . '.dashboard');
    })->name('dashboard');

    // Area khusus ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });

    // Area khusus PETUGAS
    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
    });

    // Area khusus CUSTOMER
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'customer'])->name('dashboard');
    });

        // ===== MENU USER (admin & petugas) =====
    Route::middleware('role:admin,petugas')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');

        // Detail, edit, dan hapus KHUSUS admin
        Route::middleware('role:admin')->group(function () {
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
    });

        // ===== PROFIL (semua role) =====
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

    // ===== CUSTOMER: pengaduan milik sendiri =====
    Route::middleware('role:customer')->prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/create', [PengaduanController::class, 'create'])->name('create');
        Route::post('/', [PengaduanController::class, 'store'])->name('store');
        Route::get('/{pengaduan}', [PengaduanController::class, 'show'])->name('show');
    });

    // ===== ADMIN & PETUGAS: kelola semua pengaduan =====
    Route::middleware('role:admin,petugas')->prefix('kelola-pengaduan')->name('kelola.')->group(function () {
        Route::get('/', [PengaduanController::class, 'kelola'])->name('pengaduan');
        Route::put('/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('status');
    });