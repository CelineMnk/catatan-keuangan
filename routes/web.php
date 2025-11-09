<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

// Root "/" → langsung redirect ke login
Route::get('/', function () {
    return redirect()->route('login'); // selalu ke halaman login
});

// Include route auth (login, register, password, logout)
require __DIR__.'/auth.php';

// Semua route ini hanya untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // tampilkan dashboard setelah login
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Transactions CRUD
    Route::resource('transactions', TransactionController::class);

    // Statistics
    Route::get('/statistics', [TransactionController::class, 'stats'])->name('transactions.stats');
    Route::get('/statistics/data', [TransactionController::class, 'statsData'])->name('transactions.stats.data');
});
