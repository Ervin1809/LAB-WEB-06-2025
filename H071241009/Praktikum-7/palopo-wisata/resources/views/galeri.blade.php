@extends('layouts.master')

@section('title', 'Galeri Foto')

@section('content')
    <h2>Galeri Foto Palopo</h2>
    <p>Nikmati keindahan Palopo dalam bingkai foto.</p>
    
    <div class="gallery-container">
        <img src="{{ asset('images/palopo1.jpeg') }}" alt="Foto Palopo 1">
        <img src="{{ asset('images/palopo2.jpeg') }}" alt="Foto Palopo 2">
        <img src="{{ asset('images/palopo3.jpeg') }}" alt="Foto Palopo 3">
        <img src="{{ asset('images/palopo4.jpeg') }}" alt="Foto Palopo 4">
        <img src="{{ asset('images/palopo5.jpeg') }}" alt="Foto Palopo 5">
        <img src="{{ asset('images/palopo6.jpeg') }}" alt="Foto Palopo 6">
    </div>
@endsection