@extends('layouts.master')

@section('title', 'Destinasi Wisata')

@section('content')
    <h2>Destinasi Wisata Unggulan Palopo</h2>
    <p>Berikut adalah beberapa tempat wisata yang wajib Anda kunjungi di Palopo:</p>
    
    <div class="card-container">
        <x-card 
            title="Kambo Highland" 
            imageSrc="{{ asset('images/kambo.jpeg') }}" 
            description="Dataran tinggi dengan pemandangan kabut yang menakjubkan, udara sejuk, dan spot foto yang instagramable." 
        />
        <x-card 
            title="Air Terjun Latuppa" 
            imageSrc="{{ asset('images/latuppa.jpeg') }}" 
            description="Kawasan wisata alam dengan air terjun bertingkat yang jernih, dikelilingi oleh hutan yang asri dan sejuk." 
        />
        <x-card 
            title="Pantai Labombo" 
            imageSrc="{{ asset('images/labombo.jpeg') }}" 
            description="Pantai populer di Palopo untuk menikmati matahari terbenam, dengan berbagai kafe dan tempat bersantai di tepi laut." 
        />
    </div>
@endsection