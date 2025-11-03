@extends('layouts.master')

{{-- Memberi tahu master layout untuk tidak pakai style default --}}
@section('page-id', 'destination-page')
@section('main-class', 'destination-container')
@section('title', 'Destinasi Wisata')

@section('content')

    {{-- Navigasi sudah ada di master.blade.php --}}

    <section class="dest-image-grid-section">
        <div class="dest-grid-item">
            <img src="{{ asset('images/tanjungLayar.jpg') }}" alt="Pantai Tanjung Layar">
            <h2>Pantai Tanjung Layar</h2>
        </div>
        <div class="dest-grid-item">
            <img src="{{ asset('images/curugCipolarak.jpg') }}" alt="Curug Cipolarak">
            <h2>Curug Cipolarak</h2>
        </div>
        <div class="dest-grid-item">
            <img src="{{ asset('images/karangbokor.jpeg') }}" alt="Karang Bokor">
            <h2>Karang Bokor</h2>
        </div>
    </section>
    <section class="dest-caption-section">
        <div class="dest-caption-grid">
            <div class="dest-caption-item">
                <h3>Pantai Tanjung Layar</h3>
                <p>Ikon utama Sawarna dengan dua batu karang raksasa yang menyerupai layar kapal.
                Tempat terbaik menikmati matahari terbenam.</p>
            </div>
            <div class="dest-caption-item">
                <h3>Curug Cipolarak</h3>
                <p>Air terjun indah dengan suasana asri yang menenangkan,
                tersembunyi di antara rimbunnya pepohonan di kawasan Sawarna.</p>
            </div>
            <div class="dest-caption-item">
                <h3>Karang Bokor</h3>
                <p>Pantai dengan hamparan pasir putih yang luas dan air laut yang jernih,
                cocok untuk bersantai dan berenang.</p>
            </div>
        </div>
    </section>

    <section class="dest-map-section">
        <div id="dest-map-container"></div>
    </section>

    {{-- Footer khusus halaman destinasi SUDAH DIHAPUS --}}

@endsection

@push('scripts')
<script>
    // 1. Definisikan lokasi-lokasi
    const locations = [
        {
            name: "Pantai Tanjung Layar",
            desc: "Ikon utama Sawarna.",
            coords: [-6.9915, 106.3019]
        },
        {
            name: "Curug Cipolarak",
            desc: "Air terjun asri di Sawarna.",
            coords: [-6.9693, 106.3242]
        },
        {
            name: "Karang Bokor",
            desc: "Pantai berpasir putih.",
            coords: [-6.9961, 106.3229]
        }
    ];

    // 2. Inisialisasi Peta
    var map = L.map('dest-map-container');

    // 3. Tambahkan Tile Layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // 4. Buat array 'bounds' untuk semua marker
    var bounds = [];

    // 5. Loop dan tambahkan marker
    locations.forEach(loc => {
        L.marker(loc.coords).addTo(map)
            .bindPopup(`<b>${loc.name}</b><br>${loc.desc}`);

        bounds.push(loc.coords);
    });

    // 6. Atur view peta agar semua marker terlihat
    map.fitBounds(bounds, { padding: [50, 50] });
</script>
@endpush