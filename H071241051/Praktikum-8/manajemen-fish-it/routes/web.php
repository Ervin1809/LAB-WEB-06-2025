<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishController;

Route::get('/', function () {
    return redirect()->route('fishes.index'); // Arahkan halaman utama ke daftar ikan
});

// Ini akan otomatis membuat semua route untuk index, create, store, 
// show, edit, update, dan destroy.
Route::resource('fishes', FishController::class);