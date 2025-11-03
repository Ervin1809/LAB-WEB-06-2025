@extends('layouts.master')

@section('page-id', 'gallery-page')
@section('main-class', 'gallery-container')
@section('title', 'Galeri')

@section('content')
    {{-- Daftar Gambar (class scroll-animate Dihapus) --}}
    <img src="{{ asset('images/tanjungLayar.jpg') }}" alt="Galeri Tanjung Layar" class="gallery-image">
    <img src="{{ asset('images/curugCipolarak.jpg') }}" alt="Galeri Curug Cipolarak" class="gallery-image">
    <img src="{{ asset('images/karangbokor.jpeg') }}" alt="Galeri Karang Bokor" class="gallery-image">
    <img src="{{ asset('images/baduy.jpeg') }}" alt="Galeri Suku Baduy" class="gallery-image">
    <img src="{{ asset('images/orangbaduy.jpeg') }}" alt="Galeri Orang Baduy" class="gallery-image">
    <img src="{{ asset('images/rumah baduy.jpg') }}" alt="Galeri Rumah Baduy" class="gallery-image">
    <img src="{{ asset('images/kebuntehcikuya.jpg') }}" alt="Galeri Kebun Teh Cikuya" class="gallery-image">
    <img src="{{ asset('images/UjungKulon.jpeg') }}" alt="Galeri Ujung Kulon" class="gallery-image">
    <img src="{{ asset('images/Ujung Kulon.jpeg') }}" alt="Galeri Ujung Kulon 2" class="gallery-image">
    <img src="{{ asset('images/Mooto_graphy.jpeg') }}" alt="Galeri Mooto Graphy" class="gallery-image">
    <img src="{{ asset('images/Mooto_graphy (1).jpeg') }}" alt="Galeri Mooto Graphy 2" class="gallery-image">

@endsection

@push('scripts')
@endpush