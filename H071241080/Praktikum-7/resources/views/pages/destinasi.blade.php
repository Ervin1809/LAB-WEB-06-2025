@extends('layouts.master')

@section('content')
<style>
    .page-header {
        margin-bottom: 3rem;
        max-width: 800px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: #2C2C2C;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }

    .page-intro {
        font-size: 1.0625rem;
        color: #666666;
        line-height: 1.8;
        font-weight: 300;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Menjelajahi Destinasi Alam Enrekang</h1>
    <p class="page-intro">
        Rasakan udara segar Bumi Massenrempulu dan taklukkan panorama tiada tara. Dari trekking menantang hingga air terjun yang tersembunyi, inilah daftar keindahan alam yang wajib Anda jelajahi.
    </p>
</div>

<div class="card-grid">
    <x-card 
        title="Gunung Latimojong" 
        image="{{ asset('images/destinasi-images/latimojong1.jpg') }}"
        description="Gunung tertinggi di Sulawesi dan bagian dari Seven Summits of Indonesia. Puncak Rante Mario (3.430 mdpl) menawarkan pendakian epik dan pemandangan luar biasa di atap Sulawesi."
    />

    <x-card 
        title="Kebun Raya Massenrempulu" 
        image="{{ asset('images/destinasi-images/kebunraya2.jpg') }}"
        description="Kebun raya seluas 300 hektar yang belum setenar lainnya, menawarkan padang rumput, danau kecil, dan koleksi lebih dari 6.000 spesies tanaman, termasuk flora endemik Sulawesi."
    />
    
    <x-card 
        title="Desa Wisata Kadingeh" 
        image="{{ asset('images/destinasi-images/kadingeh2.jpg') }}"
        description="Desa perpaduan alam, budaya, dan sejarah yang masuk 300 besar ADWI 2021. Menyajikan Gua Purba Loko’ Wai Lambun, Air Terjun Sarambu Alla, dan Permandian Alam Salu Cengnge."
    />

    <x-card 
        title="Dante Pine Enrekang" 
        image="{{ asset('images/destinasi-images/dantepine2.jpg') }}"
        description="Hutan pinus rimbun yang menjadi pilihan warga untuk bersantai, berkemah, dan menikmati udara segar. Tempat ini dipenuhi spot foto yang menakjubkan dan dibangun secara swadaya"
    />

    <x-card 
        title="Air Terjun Lewaja" 
        image="{{ asset('images/destinasi-images/lewaja3.jpg') }}"
        description="Destinasi wisata alam unggulan, hanya sekitar 15 menit dari pusat kota Enrekang. Cocok untuk refreshing cepat dan menikmati kesegaran air di Kelurahan Lewaja."
    />

    <x-card 
        title="Laburang Gallang" 
        image="{{ asset('images/destinasi-images/laburanggallang2.jpg') }}"
        description="Permandian alami tersembunyi dengan suasana asri. Dikenal karena kolam-kolam alami yang terbentuk oleh susunan bebatuan besar, ideal untuk berenang dan bersantai di tengah ketenangan alam pegunungan."
    />
</div>
@endsection