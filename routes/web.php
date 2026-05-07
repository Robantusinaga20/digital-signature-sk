<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KunciController;

// =====================
// HALAMAN PUBLIK
// =====================
Route::get('/', function () {
    return view('verifikasi.index');
})->name('verifikasi');

// =====================
// AUTH (Breeze)
// =====================
require __DIR__.'/auth.php';


// Blokir akses register dari publik
Route::get('/register', fn() => redirect()->route('login'))->name('register');
Route::post('/register', fn() => redirect()->route('login'));

// =====================
// HALAMAN ADMIN (butuh login)
// =====================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Users (kelola akun)
    Route::get('/users',            [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create',     [UserController::class, 'create'])->name('users.create');
    Route::post('/users',           [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}',  [UserController::class, 'destroy'])->name('users.destroy');
    
    //Route Data Kunci
    Route::get('/kunci',            [KunciController::class, 'index'])->name('kunci.index');
    Route::get('/kunci/generate',   [KunciController::class, 'generate'])->name('kunci.generate');
    Route::post('/kunci',           [KunciController::class, 'store'])->name('kunci.store');
    Route::delete('/kunci/{id}',    [KunciController::class, 'destroy'])->name('kunci.destroy');    
    // Placeholder — akan diisi di phase berikutnya
    Route::get('/tanda-tangan', fn() => abort(404))->name('tanda-tangan.index');
});