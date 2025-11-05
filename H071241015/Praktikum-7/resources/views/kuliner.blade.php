@extends('layouts.master')

@section('title', 'Kuliner')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-16 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Kuliner Khas Bali</h1>
            <p class="text-xl mb-6">Rasakan kelezatan masakan tradisional Bali yang kaya rasa dan aroma</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/BebekBetutu.png') }}" class="w-full h-full object-cover" alt="Bebek Betutu">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Bebek Betutu</h3>
            <p class="text-gray-600 mb-4">Daging bebek yang dimasak dengan bumbu rempah khas Bali, dibungkus daun pisang dan dipanggang dalam bara api. Rasa gurih dan wangi rempahnya membuat hidangan ini legendaris.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/Sate_lilit.jpg') }}" class="w-full h-full object-cover" alt="Sate Lilit">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Sate Lilit</h3>
            <p class="text-gray-600 mb-4">Sate khas Bali yang terbuat dari daging ikan atau ayam yang dicincang halus dan dimasak dengan bumbu rempah, kemudian dililitkan pada batang sereh sebelum dibakar.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star-half-alt mr-1"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/babiguling.png') }}" class="w-full h-full object-cover" alt="Babi Guling">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Babi Guling</h3>
            <p class="text-gray-600 mb-4">Hidangan babi utuh yang dipanggang berisi bumbu rempah dan jeroan. Merupakan hidangan utama dalam perayaan dan upacara adat Bali yang memiliki rasa yang sangat khas.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/nasicampurbali.jpg') }}" class="w-full h-full object-cover" alt="Nasi Campur">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Nasi Campur Bali</h3>
            <p class="text-gray-600 mb-4">Nasi putih yang disajikan dengan berbagai lauk pauk khas Bali seperti sambal matah, sayur urap, sate lilit, dan emping. Hidangan sehat dan gurih.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="far fa-star mr-1"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/lawar.jpg') }}" class="w-full h-full object-cover" alt="Lawar">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Lawar</h3>
            <p class="text-gray-600 mb-4">Campuran sayuran, kelapa, dan bumbu khas Bali yang bisa ditambahkan daging babi atau ayam. Makanan ini memiliki tekstur dan rasa yang unik.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star-half-alt mr-1"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('images/jejebali.jpg') }}" class="w-full h-full object-cover" alt="Jaje">
        </div>
        <div class="p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Jaje Bali</h3>
            <p class="text-gray-600 mb-4">Makanan penutup tradisional Bali yang terdiri dari berbagai kue-kue tradisional seperti jaje kluwing, jaje uli, dan jaje bandung yang lezat.</p>
            <div class="flex items-center text-yellow-500">
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
                <i class="fas fa-star mr-1"></i>
            </div>
        </div>
    </div>
</div>
@endsection