@extends('layouts.master')

@section('page-id', 'contact') {{-- <-- TAMBAHKAN BARIS INI --}}
@section('title', 'Kontak')

@section('content')
    <h2>Hubungi Kami</h2>
    <p>Punya pertanyaan atau ingin merencanakan perjalanan? Hubungi kami!</p>
    
    <p>
        <strong>Email:</strong> info@sawarna.com<br>
        <strong>Telepon:</strong> +62 123 4567 890
    </p>

    <div id="map-container"></div>

    <hr style="margin: 30px 0; border-color: rgba(255,255,255,0.3);">

    <form action="#" method="POST">
        <div class="form-group">
            <label for="nama">Nama Anda:</label>
            <input type="text" id="nama" name="nama">
        </div>
        <div class="form-group">
            <label for="email">Email Anda:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="5"></textarea>
        </div>
        <button type="submit">Kirim Pesan</button>
    </form>
@endsection

@push('scripts')
{{-- Script Peta Anda tidak berubah --}}
<script>
    var lat = -6.9825;
    var lon = 106.3050;
    var map = L.map('map-container').setView([lat, lon], 14); 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    L.marker([lat, lon]).addTo(map)
        .bindPopup('<b>Desa Wisata Sawarna</b><br>Banten, Indonesia.')
        .openPopup();
</script>
@endpush