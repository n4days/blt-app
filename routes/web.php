<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [GoogleController::class, 'index'])->name('login');
Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Route::middleware('auth')->group(function () {
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/master-masyarakat', function () {
    return view('mastermasyarakat');
})->name('mastermasyarakat');
