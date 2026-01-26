<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasporController;

Route::get('/', [PasporController::class, 'index']);
Route::post('/cetak-pdf', [PasporController::class, 'cetak'])->name('cetak.proses');
