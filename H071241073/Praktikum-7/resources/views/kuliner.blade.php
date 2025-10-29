@extends('layouts.master')

@section('title', 'Kuliner Khas')

@section('content')
<h2 class="text-4xl font-bold mb-4 pb-2 border-b-4 border-yellow-500 text-center drop-shadow-md">
    Kuliner Khas Toraja Utara
</h2>

<p class="text-lg text-gray-700 leading-relaxed mb-10 text-center max-w-3xl mx-auto">
    Jangan lewatkan untuk mencicipi berbagai hidangan otentik khas Toraja Utara yang kaya rasa dan tradisi:
</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    <x-card 
        title="Pa'piong" 
        imgSrc="Papiong.jpg" 
        description="Masakan tradisional yang dimasak di dalam bambu. Biasanya berisi daging (babi, ayam, atau ikan) dicampur dengan sayur daun mayana dan bumbu khas Toraja." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Pantollo' Pamarrasan" 
        imgSrc="pamarrasan.jpg" 
        description="Daging (biasanya babi atau ikan) dimasak dengan bumbu kluwek (pamarrasan) berwarna hitam pekat yang memberikan rasa gurih dan unik khas Toraja." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Kopi Toraja" 
        imgSrc="kopi_toraja.jpg" 
        description="Kopi arabika terbaik dari pegunungan Toraja, terkenal dengan aroma yang kuat dan cita rasa kompleks — favorit para penikmat kopi dunia." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Deppa Tori" 
        imgSrc="deppa_tori.jpg" 
        description="Kue khas Toraja yang terbuat dari tepung beras dan gula merah. Memiliki rasa manis-gurih serta tekstur renyah yang disukai banyak orang." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Pangrarang" 
        imgSrc="pangrarang.jpg" 
        description="Sate khas Toraja, biasanya menggunakan daging babi yang dimarinasi dengan rempah-rempah tradisional sebelum dibakar hingga harum dan empuk." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

    <x-card 
        title="Piong Bo'bo (Nasi Bambu)" 
        imgSrc="nasi_bambu.jpg" 
        description="Nasi yang dimasak bersama santan di dalam bambu, menghasilkan aroma harum dan rasa gurih. Biasanya disajikan bersama Pa'piong atau Pantollo'." 
        class="transform hover:scale-105 transition-transform duration-500 shadow-lg hover:shadow-2xl rounded-xl overflow-hidden"
    />

</div>
@endsection
