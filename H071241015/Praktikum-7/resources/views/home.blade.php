@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-20 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Selamat Datang di Bali</h1>
            <p class="text-xl md:text-2xl mb-8">Nikmati keindahan Pulau Dewata yang memukau hati</p>
            <a href="{{ url('/destinasi') }}" class="bg-white text-primary hover:bg-accent font-bold py-3 px-8 rounded-full text-lg transition duration-300 inline-block">
                Jelajahi Destinasi
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-xl p-8 mb-12">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Keindahan Bali</h2>
        <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto"></div>
    </div>
    
    <div class="max-w-4xl mx-auto">
        <p class="text-lg text-gray-700 mb-6">Bali adalah surga wisata yang menyuguhkan keindahan alam yang luar biasa. Dikenal sebagai Pulau Dewata, Bali menawarkan berbagai destinasi wisata yang memukau mulai dari pantai berpasir putih, gunung yang megah, hingga pura-pura kuno yang sakral.</p>
        
        <p class="text-lg text-gray-700 mb-8">Pulau ini juga kaya akan budaya dan seni tradisional yang masih dilestarikan hingga kini. Masyarakat Bali yang ramah dan penuh keramahan akan membuat kunjungan Anda semakin berkesan.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="text-center group">
                <div class="bg-gradient-to-r from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-temple text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pura dan Budaya</h3>
                <p class="text-gray-600">Jelajahi pura-pura kuno yang sarat dengan nilai spiritual dan budaya Bali yang kental.</p>
            </div>
            
            <div class="text-center group">
                <div class="bg-gradient-to-r from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-water text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pantai Indah</h3>
                <p class="text-gray-600">Nikmati keindahan pantai-pantai eksotis dengan pasir putih dan air laut yang jernih.</p>
            </div>
            
            <div class="text-center group">
                <div class="bg-gradient-to-r from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-mountain text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Alam yang Eksotis</h3>
                <p class="text-gray-600">Temukan keindahan alam Bali dari gunung, sawah terasering, hutan hujan, dan lebih.</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-12">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Keindahan Bali</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group overflow-hidden rounded-2xl">
            <img src="{{ asset('images/PuraBudaya.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Pura di Bali">
            <div class="bg-white p-4">
                <h3 class="text-xl font-bold text-gray-800">Pura dan Budaya</h3>
            </div>
        </div>
        
        <div class="group overflow-hidden rounded-2xl">
            <img src="{{ asset('images/pantaibali.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Pantai di Bali">
            <div class="bg-white p-4">
                <h3 class="text-xl font-bold text-gray-800">Pantai Indah</h3>
            </div>
        </div>
        
        <div class="group overflow-hidden rounded-2xl">
            <img src="{{ asset('images/AlamEksotis.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Gunung di Bali">
            <div class="bg-white p-4">
                <h3 class="text-xl font-bold text-gray-800">Alam yang Eksotis</h3>
            </div>
        </div>
    </div>
</div>
@endsection