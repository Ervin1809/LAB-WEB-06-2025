<?php

use Illuminate\Support\Facades\Route;

// Halaman Home (Akar)
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Tentang
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Halaman Destinasi
Route::get('/destinasi', function () {
    return view('destinasi');
})->name('destinasi');

// Halaman Kuliner
Route::get('/kuliner', function () {
    return view('kuliner');
})->name('kuliner');

// Halaman Galeri
Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

// Halaman Event
Route::get('/event', function () {
    return view('event');
})->name('event');

// Halaman Kontak
Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');
