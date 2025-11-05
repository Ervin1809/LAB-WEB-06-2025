<?php

use Illuminate\Support\Facades\Route;

// Halaman Home
Route::get('/', function () {
    return view('pages.home');
});

// Halaman Destinasi
Route::get('/destinasi', function () {
    return view('pages.destinasi');
});

// Halaman Kuliner
Route::get('/kuliner', function () {
    return view('pages.kuliner');
});

// Halaman Galeri
Route::get('/galeri', function () {
    return view('pages.galeri');
});

// Halaman Kontak
Route::get('/kontak', function () {
    return view('pages.kontak');
});


