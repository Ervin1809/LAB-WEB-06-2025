@extends('layouts.master')

@section('title', 'Galeri Foto')

@section('content')
<h2 class="text-4xl font-bold mb-4 pb-2 border-b-4 border-yellow-500 text-center drop-shadow-md">
    Galeri Foto Toraja Utara
</h2>

<p class="text-lg text-gray-700 leading-relaxed mb-10 text-center max-w-3xl mx-auto">
    Menikmati keindahan alam, budaya, dan kehidupan masyarakat Toraja Utara melalui potret indah berikut:
</p>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/batutumonga.jpg') }}" alt="Pemandangan Toraja Utara 1" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg.jpg') }}" alt="Pemandangan Toraja Utara 2" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg2.jpg') }}" alt="Pemandangan Toraja Utara 3" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg3.jpg') }}" alt="Pemandangan Toraja Utara 4" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg4.jpg') }}" alt="Pemandangan Toraja Utara 5" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg6.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg8.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bg9.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/bori-kalimbuang.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/deppa_tori.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/kete-kesu.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/kopi_toraja.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/lokomata.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/Lolai.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/pamarrasan.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/pangrarang.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/Papiong.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/pasar-bolu.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tentang1.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tentang2.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tentang3.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tenuntobarana.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/torajabg.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tif.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tif2.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/rambu_solo.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/rambu_solo1.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>
    
    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/rambu_tuka.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/lambuk.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/tari1.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/ma-nene.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/londa.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/barang.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>

    <div class="overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-500">
        <img src="{{ asset('images/alat-musik.jpg') }}" alt="Pemandangan Toraja Utara 6" class="w-full h-64 object-cover">
    </div>
    
</div>
@endsection
