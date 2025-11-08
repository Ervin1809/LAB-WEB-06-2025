@extends('layouts.master')

@section('title', 'Kontak')

@section('content')
<div class="relative bg-gradient-to-r from-primary to-secondary text-white py-16 mb-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-xl mb-6">Informasi kontak dan form sederhana untuk komunikasi lebih lanjut</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h3>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="bg-primary p-3 rounded-full mr-4">
                    <i class="fas fa-map-marker-alt text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">Alamat</h4>
                    <p class="text-gray-600">Jl. Pariwisata No. 1, Denpasar, Bali</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-primary p-3 rounded-full mr-4">
                    <i class="fas fa-phone-alt text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">Telepon</h4>
                    <p class="text-gray-600">(0361) 123456</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-primary p-3 rounded-full mr-4">
                    <i class="fas fa-envelope text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">Email</h4>
                    <p class="text-gray-600">info@eksplorpariwisanusantara.com</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-primary p-3 rounded-full mr-4">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">Waktu Operasional</h4>
                    <p class="text-gray-600">Senin - Minggu, 08:00 - 17:00 WITA</p>
                </div>
            </div>
        </div>
        
        <div class="mt-8 bg-gray-200 rounded-xl h-64 flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-map-marked-alt text-primary text-4xl mb-2"></i>
                <p class="text-gray-600">Lokasi Kami di Peta</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>
        
        <form>
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="nama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan nama Anda">
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan email Anda">
            </div>
            
            <div class="mb-4">
                <label for="subjek" class="block text-gray-700 font-medium mb-2">Subjek</label>
                <input type="text" id="subjek" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan subjek pesan">
            </div>
            
            <div class="mb-6">
                <label for="pesan" class="block text-gray-700 font-medium mb-2">Pesan</label>
                <textarea id="pesan" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Tulis pesan Anda di sini"></textarea>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3 px-6 rounded-lg hover:opacity-90 transition duration-300">
                Kirim Pesan
            </button>
        </form>
    </div>
</div>
@endsection