@extends('layouts.master')

@section('content')
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8" style="font-family: 'LontaraBugis', sans-serif;">Galeri Foto Makassar</h1>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Jelajahi keindahan Makassar melalui kumpulan foto-foto menakjubkan.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/akkarena.jpg') }}" alt="Pemandangan Pantai" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/benteng_rotterdam.jpg') }}" alt="Benteng Rotterdam" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/Kuliner.jpg') }}" alt="Kuliner" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/samalona.jpg') }}" alt="Kegiatan Wisata" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/makassar.jpg') }}" alt="Kota Makassar" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/(O-O)-14.jpg') }}" alt="Sunset di Pantai" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/konro.jpeg') }}" alt="Makanan Khas" class="w-full h-48 object-cover">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img src="{{ asset('images/budaya.png') }}" alt="Orang-orang Makassar" class="w-full h-48 object-cover">
                </div>
            </div>
            <br>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Masih banyak lagi di update mendatang.
            </p>
        </div>
    </section>
@endsection