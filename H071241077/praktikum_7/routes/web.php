<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PetaController;

// Wajib
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/kuliner', [KulinerController::class, 'index'])->name('kuliner');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');

// Tambahan
Route::get('/event', [EventController::class, 'index'])->name('event');

