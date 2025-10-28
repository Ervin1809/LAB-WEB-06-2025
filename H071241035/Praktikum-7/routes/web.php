<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/destinasi', function () {
    return view('pages.destinasi');
});

Route::get('/kuliner', function () {
    return view('pages.kuliner');
});

Route::get('/galeri', function () {
    return view('pages.galeri');
});

Route::get('/kontak', function () {
    return view('pages.kontak');
});