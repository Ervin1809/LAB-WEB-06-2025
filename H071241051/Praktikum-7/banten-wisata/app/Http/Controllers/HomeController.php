<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan halaman Home 
    public function home()
    {
        return view('home');
    }

    // Menampilkan halaman Destinasi 
    public function destinasi()
    {
        return view('destinasi');
    }

    // Menampilkan halaman Kuliner 
    public function kuliner()
    {
        return view('kuliner');
    }

    // Menampilkan halaman Galeri 
    public function galeri()
    {
        return view('galeri');
    }

    // Menampilkan halaman Kontak 
    public function kontak()
    {
        return view('kontak');
    }
}