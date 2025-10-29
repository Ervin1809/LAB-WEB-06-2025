@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div 
    class="relative w-full min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center" 
    style="background-image: url('{{ asset('images/bg8.jpg') }}');"
>
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black/80"></div>

    {{-- Konten utama --}}
    <div class="relative z-10 text-center text-white px-6 max-w-3xl">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg tracking-wide">
            Selamat Datang di <span class="text-yellow-400">Eksplor Toraja Utara</span>
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-10 leading-relaxed drop-shadow-md">
            Temukan keajaiban budaya, panorama alam yang memukau, serta kehangatan masyarakat Toraja Utara.
            Mari jelajahi setiap sudutnya dan rasakan pesona tanah yang kaya akan tradisi dan keindahan.
        </p>

        <a 
            href="{{ url('/destinasi') }}" 
            class="bg-yellow-500 text-gray-900 font-bold py-3 px-10 rounded-full text-lg shadow-lg 
                   hover:bg-yellow-400 transform hover:scale-105 transition duration-300 ease-in-out"
        >
            Jelajahi Destinasi
        </a>
    </div>
</div>
@endsection