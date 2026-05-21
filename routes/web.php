<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasporController;
use App\Http\Controllers\AuthController; // Pastikan AuthController di-import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN PUBLIK (Bisa Diakses Semua Orang)
// ==========================================
Route::get('/', [PasporController::class, 'index']);
Route::post('/cetak-pdf', [PasporController::class, 'cetak'])->name('cetak.proses');
Route::get('/cari-spri/{nomor}', [PasporController::class, 'cariDataSpri']);


// ==========================================
// 2. HALAMAN OTENTIKASI (Login/Logout)
// ==========================================
// Menampilkan Form Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses kirim data login
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. HALAMAN ADMIN (DIPROTEKSI PASSWORD)
// ==========================================
// Semua route di dalam group ini WAJIB login dulu. 
// Jika belum login, otomatis ditendang ke halaman /login.
Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin/dashboard', [PasporController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/dashboard/hapus/{id}', [App\Http\Controllers\PasporController::class, 'hapusRiwayat'])->name('riwayat.hapus');
    
});