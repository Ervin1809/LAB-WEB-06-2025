@extends('layouts.master')

{{-- Memberi instruksi ke master.blade.php --}}
@section('page-id', 'landing')
@section('main-class', 'landing-container')
@section('title', 'Selamat Datang')

@section('content')
    
    {{-- Video Latar Belakang --}}
    <div class="landing-video-background">
        <video autoplay muted loop id="landing-bg-video">
            <source src="{{ asset('videos/sawarna.mp4') }}" type="video/mp4">
        </video>
    </div>

    {{-- Overlay untuk menggelapkan video dan menampung konten --}}
    <div class="landing-overlay">
        
        <div class="landing-top">
            <img src="{{ asset('images/logobadak.png') }}" alt="Logo Banten" class="landing-logo">
        </div>

        <div class="landing-middle">
            <h1 class="landing-tagline">Sawarna, Pesona Tersembunyi di Pesisir Selatan</h1>
        </div>

        <div class="landing-bottom-content">
            
            <h2 class="explore-title-bottom">JELAJAHI</h2>

            <div class="landing-nav-links">
                <a href="/destinasi" class="nav-link-item">
                    <h3>Destinasi</h3>
                </a>
                <a href="/kuliner" class="nav-link-item">
                    <h3>Kuliner</h3>
                </a>
                <a href="/galeri" class="nav-link-item">
                    <h3>Galeri</h3>
                </a>
                <a href="/kontak" class="nav-link-item">
                    <h3>Kontak</h3>
                </a>
            </div>
        </div>

    </div>
@endsection