<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasyarakatController;

Route::get('/login', [GoogleController::class, 'index'])->name('login');
Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Route::middleware('auth')->group(function () {
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/master-masyarakat', [MasyarakatController::class, 'index'])
    ->name('mastermasyarakat');

Route::post('/master-masyarakat', [MasyarakatController::class, 'store'])
    ->name('mastermasyarakat.store');

Route::put('/master-masyarakat/{masyarakat}', [MasyarakatController::class, 'update'])
    ->name('mastermasyarakat.update');

Route::delete('/master-masyarakat/{masyarakat}', [MasyarakatController::class, 'destroy'])
    ->name('mastermasyarakat.destroy');
