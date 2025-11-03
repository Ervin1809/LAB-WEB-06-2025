@extends('layouts.master')

@section('title', 'Kuliner Khas')

@section('content')
    <h2>Kuliner Khas Palopo</h2>
    <p>Jangan lewatkan untuk mencicipi makanan khas Palopo yang lezat:</p>

    <div class="card-container">
        <x-card 
            title="Kapurung" 
            imageSrc="{{ asset('images/kapurung.jpg') }}" 
            description="Makanan khas berbahan dasar sagu yang disajikan dengan kuah ikan, sayuran, dan potongan lauk pauk." 
        />
        <x-card 
            title="Pacco'" 
            imageSrc="{{ asset('images/pacco.jpeg') }}" 
            description="Olahan ikan mentah (biasanya ikan teri) yang dicampur dengan cuka, cabai, dan bumbu rempah khas." 
        />
        <x-card 
            title="Dange" 
            imageSrc="{{ asset('images/dange.jpeg') }}" 
            description="Makanan khas berbahan dasar parutan kelapa yang dipadatkan dan dibakar, biasanya disajikan bersama ikan bakar dan sambal sebagai pelengkap hidangan." 
        />
    </div>
@endsection