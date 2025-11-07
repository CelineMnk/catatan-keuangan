<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

// halaman utama (login dulu, kecuali sudah login)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

// aktifkan semua route autentikasi (login, register, logout, dll)
require __DIR__ . '/auth.php';

// semua halaman yang butuh login
Route::middleware(['auth'])->group(function () {

    // dashboard setelah login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD catatan keuangan
    Route::resource('transactions', TransactionController::class);
    
    // Statistik keuangan
    Route::get('/statistics', [TransactionController::class, 'stats'])->name('transactions.stats');
    Route::get('/statistics/data', [TransactionController::class, 'statsData'])->name('transactions.stats.data');
});
