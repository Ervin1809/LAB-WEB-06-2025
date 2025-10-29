@extends('layouts.master')

@section('title', 'Destinasi')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #ffe5d9 0%, #ffd4c4 100%);
        font-family: 'Poppins', sans-serif;
    }

    .destinasi-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 40px 20px;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255, 235, 230, 0.9) 100%);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(255, 138, 101, 0.15);
    }

    .destinasi-header h2 {
        color: #ff7e5f;
        font-size: 2.8em;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .destinasi-header p {
        color: #555;
        font-size: 1.15em;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .provinsi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 35px;
        margin-bottom: 60px;
    }

    .provinsi-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(255, 126, 95, 0.15);
        transition: all 0.4s ease;
        position: relative;
    }

    .provinsi-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(255, 126, 95, 0.3);
    }

    .provinsi-card-img {
        width: 100%;
        aspect-ratio: 16/9; /* DIBUAT LANDSCAPE */
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .provinsi-card:hover .provinsi-card-img {
        transform: scale(1.1);
    }

    .provinsi-card-content {
        padding: 25px;
        background: linear-gradient(to bottom, #ffffff 0%, #fff5f0 100%);
    }

    .provinsi-card h3 {
        color: #ff7e5f;
        font-size: 1.5em;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .provinsi-card-location {
        color: #ff9a76;
        font-size: 0.95em;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .provinsi-card p {
        color: #555;
        line-height: 1.7;
        font-size: 0.96em;
    }

    @media (max-width: 768px) {
        .destinasi-header h2 {
            font-size: 2em;
        }
        .destinasi-header p {
            font-size: 1em;
        }
        .provinsi-grid {
            gap: 25px;
        }
    }
</style>

<div class="destinasi-header">
    <h2>Destinasi Unggulan Nusa Tenggara Timur</h2>
    <p>Temukan keajaiban alam dan budaya dari 10 destinasi terbaik di NTT – dari pantai, danau, hingga puncak gunung yang menakjubkan.</p>
</div>

<div class="provinsi-grid">
    {{-- 1. Pulau Padar --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pulau-padar.jpg') }}" class="provinsi-card-img" alt="Pulau Padar">
        <div class="provinsi-card-content">
            <h3>Pulau Padar</h3>
            <div class="provinsi-card-location">📍 Labuan Bajo, Flores</div>
            <p>Pemandangan bukit savana dengan tiga teluk berpasir warna berbeda. Spot foto paling ikonik di Flores.</p>
        </div>
    </div>

    {{-- 2. Danau Kelimutu --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/danau-kelimutu.png') }}" class="provinsi-card-img" alt="Danau Kelimutu">
        <div class="provinsi-card-content">
            <h3>Danau Kelimutu</h3>
            <div class="provinsi-card-location">📍 Ende, Flores</div>
            <p>Tiga danau kawah yang dapat berubah warna secara alami karena aktivitas vulkanik dan mineralnya.</p>
        </div>
    </div>

    {{-- 3. Pantai Nihiwatu --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pantai-nihiwatu.jpg') }}" class="provinsi-card-img" alt="Pantai Nihiwatu">
        <div class="provinsi-card-content">
            <h3>Pantai Nihiwatu</h3>
            <div class="provinsi-card-location">📍 Sumba Barat</div>
            <p>Termasuk salah satu pantai terbaik dunia dengan resort eksklusif dan ombak sempurna untuk surfing.</p>
        </div>
    </div>

    {{-- 4. Pulau Komodo --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pulau-komodo.jpg') }}" class="provinsi-card-img" alt="Pulau Komodo">
        <div class="provinsi-card-content">
            <h3>Pulau Komodo</h3>
            <div class="provinsi-card-location">📍 Manggarai Barat</div>
            <p>Habitat asli komodo, reptil purba satu-satunya di dunia. Dikenal akan keindahan pantai pink-nya.</p>
        </div>
    </div>

    {{-- 5. Wae Rebo --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/wae-rebo.jpg') }}" class="provinsi-card-img" alt="Wae Rebo">
        <div class="provinsi-card-content">
            <h3>Desa Wae Rebo</h3>
            <div class="provinsi-card-location">📍 Manggarai, Flores</div>
            <p>Desa tradisional di atas pegunungan yang dikenal dengan rumah kerucut Mbaru Niang dan budaya leluhur.</p>
        </div>
    </div>

    {{-- 6. Pulau Alor --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pulau-alor.jpg') }}" class="provinsi-card-img" alt="Pulau Alor">
        <div class="provinsi-card-content">
            <h3>Pulau Alor</h3>
            <div class="provinsi-card-location">📍 Alor</div>
            <p>Destinasi menyelam kelas dunia dengan biota laut menakjubkan dan air sebening kristal.</p>
        </div>
    </div>

    {{-- 7. Bukit Cinta --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/bukit-cinta.jpg') }}" class="provinsi-card-img" alt="Bukit Cinta">
        <div class="provinsi-card-content">
            <h3>Bukit Cinta</h3>
            <div class="provinsi-card-location">📍 Labuan Bajo</div>
            <p>Tempat terbaik menikmati matahari terbenam di Labuan Bajo dengan panorama savana yang romantis.</p>
        </div>
    </div>

    {{-- 8. Pantai Koka --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pantai-koka.jpeg') }}" class="provinsi-card-img" alt="Pantai Koka">
        <div class="provinsi-card-content">
            <h3>Pantai Koka</h3>
            <div class="provinsi-card-location">📍 Sikka, Flores</div>
            <p>Pantai dengan pasir putih lembut dan air laut biru jernih diapit dua tebing alami yang megah.</p>
        </div>
    </div>

    {{-- 9. Gunung Egon --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/gunung-egon.jpeg') }}" class="provinsi-card-img" alt="Gunung Egon">
        <div class="provinsi-card-content">
            <h3>Gunung Egon</h3>
            <div class="provinsi-card-location">📍 Sikka, Flores Timur</div>
            <p>Gunung aktif yang menawarkan jalur pendakian dengan pemandangan kawah dan panorama laut biru.</p>
        </div>
    </div>

    {{-- 10. Pink Beach --}}
    <div class="provinsi-card">
        <img src="{{ asset('images/pink-beach.jpg') }}" class="provinsi-card-img" alt="Pink Beach">
        <div class="provinsi-card-content">
            <h3>Pink Beach</h3>
            <div class="provinsi-card-location">📍 Pulau Komodo</div>
            <p>Pantai langka dengan pasir berwarna pink natural akibat pecahan karang merah, surga snorkeling.</p>
        </div>
    </div>
</div>
@endsection
