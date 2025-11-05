<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|  rute web untuk aplikasi.
|
*/

Route::get('/', function () {
    return view('home'); // Akan memanggil file resources/views/home.blade.php
});

Route::get('/destinasi', function () {
    return view('destinasi'); // Akan memanggil file resources/views/destinasi.blade.php
});

Route::get('/kuliner', function () {
    return view('kuliner'); // Akan memanggil file resources/views/kuliner.blade.php
});

Route::get('/galeri', function () {
    return view('galeri'); // Akan memanggil file resources/views/galeri.blade.php
});

Route::get('/kontak', function () {
    return view('kontak'); // Akan memanggil file resources/views/kontak.blade.php
});