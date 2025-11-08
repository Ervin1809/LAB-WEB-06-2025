@extends('layouts.master')

@section('title', 'Galeri')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-16 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri Foto Bali</h1>
            <p class="text-xl mb-6">Menyajikan keindahan alam, budaya, dan keramahtamahan Bali</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/TanahLot.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Pura Tanah Lot">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Pura Tanah Lot yang megah berdiri di atas batu karang</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/images.jpeg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Tarian Kecak">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Tarian Kecak yang memukau di Uluwatu dengan latar belakang laut</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/pantaibali.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Sunset di Bali">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Keindahan matahari terbenam di pantai Bali</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/Ubud.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Sawah Terasering">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Sawah terasering di Tegallalang, Ubud yang memukau</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/Kintamani.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Gunung Batur">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Gunung Batur yang menjulang dengan danau di sekitarnya</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/PantaiPandawa.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Kera di Ubud">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Kera lucu di Sacred Monkey Forest Sanctuary, Ubud</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/PuraBudaya.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Upacara Adat">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Upacara adat Bali dengan pakaian tradisional yang indah</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/AlamEksotis.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Pasar Tradisional">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Keramaian pasar tradisional dengan hasil bumi lokal</p>
        </div>
    </div>
    
    <div class="group overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/watulipah.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Seni Bali">
        <div class="bg-white p-4">
            <p class="text-gray-700 font-medium">Karya seni ukir dan lukis khas Bali yang menakjubkan</p>
        </div>
    </div>
</div>

@endsection