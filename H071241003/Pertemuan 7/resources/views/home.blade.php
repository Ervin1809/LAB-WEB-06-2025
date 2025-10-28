@extends('template.master')

@section('title', 'Home')

@section('content')
<section class="relative min-h-[78vh] flex items-center justify-center">
  <!-- overlay gelap supaya teks kebaca -->
  <!-- <div class="absolute inset-0 bg-black/40"></div> -->
<div class="fixed inset-0 bg-black/40"></div>

  <div class="relative z-10 max-w-4xl px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
      Selamat Datang di Eksplor Pariwisata Nusantara:
      <span class="block">Majene, Sulawesi Barat</span>
    </h1>

    <p class="mt-6 text-lg md:text-xl text-white/90">
      Majene dikenal sebagai "Kota Pelabuhan di Tanah Mandar" di pesisir barat Sulawesi
      yang kaya budaya, laut jernih, dan keramahan masyarakatnya. Situs ini
      mengajak Anda mengenal keindahan Majene melalui destinasi wisata, kuliner,
      dan budaya khas yang memikat hati.
    </p>

    <a href="/destinasi"
       class="inline-block mt-8 px-6 py-3 rounded-full bg-white/70 backdrop-blur
              hover:bg-white/90 text-gray-900 font-semibold transition">
      Jelajahi Sekarang
    </a>
  </div>
</section>
@endsection
