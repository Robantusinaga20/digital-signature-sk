<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KunciController;
use App\Http\Controllers\SkPenugasanController;
 use App\Http\Controllers\TandaTanganController;
 use App\Http\Controllers\VerifikasiController;

// // =====================
// HALAMAN PUBLIK
// =====================
// Route::get('/', function () {
//     return view('verifikasi.index');
// })->name('verifikasi');
// // Di luar middleware auth (publik)
// Route::get('/verifikasi/cek/{token}', function($token) {
//     return redirect()->route('verifikasi')->with('token', $token);
// })->name('verifikasi.cek');

// Halaman publik
    Route::get('/', [VerifikasiController::class, 'index'])->name('verifikasi');
    Route::get('/verifikasi/cek/{token}', [VerifikasiController::class, 'cek'])->name('verifikasi.cek');
    Route::post('/verifikasi/proses', [VerifikasiController::class, 'proses'])->name('verifikasi.proses');
    Route::get('/verifikasi/token', function(\Illuminate\Http\Request $request) {
    $token = trim($request->get('token', ''));
    if (empty($token)) {
        return redirect()->route('verifikasi');
    }
    return redirect()->route('verifikasi.cek', ['token' => $token]);
})->name('verifikasi.token');

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

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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
     
    //route data SK
    Route::get('/sk',            [SkPenugasanController::class, 'index'])->name('sk.index');
    Route::get('/sk/create',     [SkPenugasanController::class, 'create'])->name('sk.create');
    Route::post('/sk',           [SkPenugasanController::class, 'store'])->name('sk.store');
    Route::get('/sk/{id}/edit',  [SkPenugasanController::class, 'edit'])->name('sk.edit');
    Route::put('/sk/{id}',       [SkPenugasanController::class, 'update'])->name('sk.update');
    Route::delete('/sk/{id}',    [SkPenugasanController::class, 'destroy'])->name('sk.destroy');
    Route::get('/sk/{id}/file',  [SkPenugasanController::class, 'viewFile'])->name('sk.file');


    // route tanda tangan
    Route::get('/tanda-tangan',              [TandaTanganController::class, 'index'])->name('tanda-tangan.index');
    Route::post('/tanda-tangan/sign/{id_sk}',[TandaTanganController::class, 'sign'])->name('tanda-tangan.sign');
    Route::get('/tanda-tangan/{id_tt}',      [TandaTanganController::class, 'detail'])->name('tanda-tangan.detail');
    Route::get('/tanda-tangan/{id_tt}/download', [TandaTanganController::class, 'download'])->name('tanda-tangan.download');
    Route::get('/tanda-tangan/{id_tt}/download-qr', [TandaTanganController::class, 'downloadQr'])->name('tanda-tangan.download-qr');
    
}
);