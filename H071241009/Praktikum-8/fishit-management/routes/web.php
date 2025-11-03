<?php

use App\Http\Controllers\FishController;
use Illuminate\Support\Facades\Route;

// Arahkan halaman utama ke index ikan
Route::get('/', [FishController::class, 'index'])->name('home');

// Ini akan otomatis membuat semua route CRUD untuk /fishes
Route::resource('fishes', FishController::class);
