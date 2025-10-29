@extends('layouts.master')

@section('title', 'Event Daerah')

@section('content')
<h2 class="text-4xl font-bold mb-4 pb-2 border-b-4 border-yellow-500 text-center drop-shadow-md">
    Event Daerah & Budaya Toraja Utara
</h2>
<p class="text-lg text-gray-700 leading-relaxed mb-10 text-center max-w-3xl mx-auto">
    Toraja Utara memiliki berbagai upacara adat dan festival budaya yang unik, menjadi daya tarik tersendiri bagi wisatawan domestik maupun mancanegara.
</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    {{-- Menggunakan komponen card dengan efek hover seperti di halaman destinasi --}}
    <x-card 
        title="Rambu Solo' (Upacara Kematian)" 
        imgSrc="rambu_solo1.jpg" 
        description="Upacara pemakaman adat yang megah dan sakral, melambangkan penghormatan terakhir kepada almarhum. Biasanya diadakan antara Juli hingga Oktober." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Rambu Tuka' (Upacara Syukur)" 
        imgSrc="rambu_tuka.jpg" 
        description="Kebalikan dari Rambu Solo', upacara ini menandai perayaan sukacita seperti peresmian Tongkonan, pernikahan, atau panen raya dengan tarian dan musik tradisional." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Toraja International Festival (TIF)" 
        imgSrc="tif.jpg" 
        description="Festival musik dan budaya tahunan yang mempertemukan seniman lokal dan internasional, digelar di situs budaya seperti Kete Kesu' atau Rantepao." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

</div>
@endsection
