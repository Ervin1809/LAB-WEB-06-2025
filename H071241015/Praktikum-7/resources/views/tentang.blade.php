@extends('layouts.master')

@section('title', 'Tentang Bali')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-16 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang Bali</h1>
            <p class="text-xl mb-6">Sejarah, budaya, dan keunikan Pulau Dewata</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-xl p-8 mb-12">
    <div class="text-center mb-12">
        <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto mb-4"></div>
        <h2 class="text-3xl font-bold text-gray-800">Sejarah & Budaya Bali</h2>
    </div>
    
    <div class="max-w-4xl mx-auto">
        <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">1</span>
                Sejarah Bali
            </h3>
            <p class="text-gray-700 leading-relaxed">Bali memiliki sejarah yang kaya dan panjang yang membentuk karakteristik budaya yang unik. Sejak abad ke-1 Masehi, Bali telah menjadi pusat perdagangan dan penyebaran agama Hindu. Pulau ini berhasil mempertahankan identitas budayanya meskipun mengalami berbagai pengaruh dari luar.</p>
        </div>
        
        <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">2</span>
                Budaya dan Agama
            </h3>
            <p class="text-gray-700 leading-relaxed">Bali dikenal sebagai "Pulau Dewata" karena kekayaan budaya dan kehidupan keagamaan yang sangat kental. Masyarakat Bali menganut agama Hindu Dharma dengan ritual-ritual yang unik dan menarik seperti upacara Galungan, Kuningan, dan Nyepi. Pura-pura yang tersebar di seluruh pulau menjadi bukti kekayaan spiritual masyarakat Bali.</p>
        </div>
        
        <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">3</span>
                Seni dan Tradisi
            </h3>
            <p class="text-gray-700 leading-relaxed">Bali juga dikenal dengan seni dan kerajinan tangan yang sangat berkembang. Tarian tradisional seperti Legong, Barong, dan Kecak menampilkan keindahan dan kekayaan seni Bali. Ukiran kayu, lukisan, dan tenun tradisional juga menjadi ciri khas karya seni Bali yang dikenal di seluruh dunia.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
            <div class="group overflow-hidden rounded-2xl shadow-lg">
                <img src="{{ asset('images/PuraBudaya.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Pura di Bali">
                <div class="bg-white p-4">
                    <p class="text-gray-700 font-medium text-center">Pura yang menjadi simbol kehidupan religi masyarakat Bali</p>
                </div>
            </div>
            
            <div class="group overflow-hidden rounded-2xl shadow-lg">
                <img src="{{ asset('images/Ubud.jpg') }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" alt="Seni di Bali">
                <div class="bg-white p-4">
                    <p class="text-gray-700 font-medium text-center">Seni dan budaya yang berkembang di kawasan Ubud</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection