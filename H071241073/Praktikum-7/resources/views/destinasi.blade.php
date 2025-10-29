@extends('layouts.master')

@section('title', 'Destinasi Wisata')

@section('content')
<h2 class="text-4xl font-bold mb-4 pb-2 border-b-4 border-yellow-500 text-center drop-shadow-md">
    Destinasi Wisata Unggulan
</h2>
<p class="text-lg text-gray-700 leading-relaxed mb-10 text-center max-w-3xl mx-auto">
    Berikut adalah beberapa destinasi yang wajib dikunjungi di Toraja Utara:
</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <x-card 
        title="Kete Kesu'" 
        imgSrc="kete-kesu.jpg" 
        description="Desa adat dengan deretan Tongkonan dan kuburan batu kuno (liang). Salah satu situs warisan budaya yang paling terkenal di Toraja." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Lolai (Negeri di Atas Awan)" 
        imgSrc="Lolai.jpg" 
        description="Nikmati pemandangan matahari terbit yang spektakuler dari atas awan. Pemandangan hamparan awan menutupi lembah di bawahnya." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Batutumonga" 
        imgSrc="batutumonga.jpg" 
        description="Area di ketinggian yang menawarkan pemandangan panorama terbaik Rantepao. Terkenal dengan udara sejuk dan hamparan sawah terasering." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Pasar Bolu (Pasar Hewan)" 
        imgSrc="pasar-bolu.jpg" 
        description="Pusat perdagangan kerbau (tedong) dan babi terbesar di Toraja. Sangat ramai pada 'Hari Pasar' (setiap 6 hari sekali)." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Sa'dan To' Barana' (Pusat Tenun)" 
        imgSrc="tenuntobarana.jpg" 
        description="Pusat kerajinan tenun ikat tradisional Toraja. Pengunjung dapat melihat langsung proses pembuatan kain tenun yang rumit dan membeli langsung." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Bori' Kalimbuang" 
        imgSrc="bori-kalimbuang.jpg" 
        description="Kompleks situs megalitikum dengan 'ranch' (batu-batu menhir) yang didirikan untuk menghormati leluhur yang telah meninggal." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Lokomata" 
        imgSrc="lokomata.jpg" 
        description="Situs pemakaman unik di sebuah batu bulat raksasa (monolit) di pinggir jalan, di mana lubang kuburan dipahat di batu tersebut." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

</div>
@endsection
