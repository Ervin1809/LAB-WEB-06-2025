@extends('layouts.master')

@section('title', 'Destinasi')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-16 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Destinasi Wisata di Bali</h1>
            <p class="text-xl mb-6">Jelajahi tempat-tempat menakjubkan yang wajib dikunjungi di Pulau Dewata</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/TanahLot.jpg') }}" class="w-full h-full object-cover" alt="Tanah Lot">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Tanah Lot</h3>
            <p class="text-gray-600 mb-4">Pura yang berdiri megah di atas batu karang, menjadi simbol keindahan religi dan alam Bali. Tempat ini sangat indah di sore hari menjelang matahari terbenam.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Kabupaten Tabanan, Bali</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/Ubud.jpg') }}" class="w-full h-full object-cover" alt="Ubud">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Ubud</h3>
            <p class="text-gray-600 mb-4">Jantung budaya Bali yang dikelilingi sawah terasering hijau, kuil-kuil kuno, dan studio seni. Tempat ini menawarkan ketenangan dan kedalaman spiritual.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Ubud, Gianyar, Bali</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/Seminyak.jpg') }}" class="w-full h-full object-cover" alt="Seminyak">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Seminyak</h3>
            <p class="text-gray-600 mb-4">Kawasan pantai mewah dengan restoran bergengsi, spa mewah, dan pantai yang indah. Tempat yang sempurna untuk menikmati kehidupan malam dan fashion Bali.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Legian, Kuta, Badung, Bali</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/Kintamani.jpg') }}" class="w-full h-full object-cover" alt="Kintamani">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Kintamani</h3>
            <p class="text-gray-600 mb-4">Destinasi dengan pemandangan Gunung dan Danau Batur yang spektakuler. Tempat ini menyajikan pemandangan gunung berapi aktif yang menakjubkan.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Kintamani, Bangli, Bali</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/watulipah.jpg') }}" class="w-full h-full object-cover" alt="Watulipah">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Watulipah</h3>
            <p class="text-gray-600 mb-4">Pantai tersembunyi dengan pasir putih yang lembut dan air laut yang jernih. Tempat ini kurang ramai pengunjung, cocok untuk yang mencari ketenangan.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Lampongsari, Klungkung, Bali</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/PantaiPandawa.jpg') }}" class="w-full h-full object-cover" alt="Pantai Pandawa">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Pantai Pandawa</h3>
            <p class="text-gray-600 mb-4">Pantai eksotis yang diapit oleh tebing-tebing tinggi dengan pasir putih bersih. Nama Pantai Pandawa diambil dari tokoh dalam cerita Mahabarata.</p>
            <div class="flex items-center text-primary">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>Pantai Pandawa, Bali</span>
            </div>
        </div>
    </div>
</div>
@endsection