@extends('layouts.master')

@section('title', 'Beranda')

@section('content')
    <h2>Selamat Datang di Website Pariwisata Palopo</h2>
    <p>
        Kota Palopo, sebuah kota indah di pesisir Provinsi Sulawesi Selatan, 
        menawarkan perpaduan unik antara keindahan alam, kekayaan sejarah, dan 
        kelezatan kuliner. Dikenal sebagai "Kota Idaman", Palopo adalah 
        gerbang menuju Tana Luwu yang eksotis.
    </p>
    <p>
        Website ini didedikasikan untuk memandu Anda menjelajahi berbagai 
        destinasi wisata, mencicipi kuliner khas, dan menikmati galeri 
        foto yang menangkap esensi keindahan Palopo.
    </p>

    <div class="home-hero">
        <img src="{{ asset('images/palopo1.jpeg') }}" alt="Landmark Kota Palopo">
    </div>
@endsection