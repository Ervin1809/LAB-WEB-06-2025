@extends('layouts.master')

@section('title', 'Galeri')

@section('content')
<style>
    .galeri-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 50px 30px;
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,235,230,0.95) 100%);
        border-radius: 24px;
        box-shadow: 0 10px 35px rgba(255, 126, 95, 0.12);
    }

    .galeri-header h2 {
        color: #ff7e5f;
        font-size: 3em;
        margin-bottom: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .galeri-header p {
        color: #555;
        font-size: 1.15em;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        aspect-ratio: 3/4;
        box-shadow: 0 10px 30px rgba(255, 126, 95, 0.15);
        cursor: pointer;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .gallery-item:hover {
        transform: scale(1.05) rotate(2deg);
        box-shadow: 0 20px 50px rgba(255, 126, 95, 0.3);
        z-index: 10;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.25);
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.85) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .overlay-title {
        color: white;
        font-size: 1.3em;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        transform: translateY(20px);
        transition: transform 0.4s ease;
    }

    .gallery-item:hover .overlay-title {
        transform: translateY(0);
    }

    .overlay-caption {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85em;
        line-height: 1.5;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        transform: translateY(20px);
        transition: transform 0.4s ease 0.1s;
    }

    .gallery-item:hover .overlay-caption {
        transform: translateY(0);
    }

    .gallery-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-top: 60px;
    }

    .stat-card {
        background: linear-gradient(135deg, #ff7e5f 0%, #ff9a76 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(255, 126, 95, 0.2);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px);
    }

    .stat-number {
        font-size: 3em;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 1.1em;
        opacity: 0.95;
    }

    @media (max-width: 768px) {
        .galeri-header h2 {
            font-size: 2em;
            flex-direction: column;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="galeri-header">
    <h2>
        <span>Galeri Foto NTT</span>
    </h2>
    <p>Jelajahi keindahan visual budaya, kuliner, event, dan keajaiban alam Nusa Tenggara Timur</p>
</div>

<div class="gallery-grid">
    {{-- DESTINASI (10 photos) --}}
    <div class="gallery-item">
        <img src="{{ asset('images/pulau-padar.jpg') }}" alt="Pulau Padar">
        <div class="gallery-overlay">
            <div class="overlay-title">Pulau Padar</div>
            <div class="overlay-caption">Pemandangan ikonik tiga teluk dari puncak bukit savana - surga para fotografer!</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/danau-kelimutu.png') }}" alt="Danau Kelimutu">
        <div class="gallery-overlay">
            <div class="overlay-title">Danau Kelimutu</div>
            <div class="overlay-caption">Tiga danau kawah vulkanik dengan warna air yang dapat berubah - keajaiban geologi yang menakjubkan.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/pantai-nihiwatu.jpg') }}" alt="Pantai Nihiwatu">
        <div class="gallery-overlay">
            <div class="overlay-title">Pantai Nihiwatu</div>
            <div class="overlay-caption">Salah satu pantai terbaik dunia dengan ombak sempurna untuk surfing.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/pulau-komodo.jpg') }}" alt="Pulau Komodo">
        <div class="gallery-overlay">
            <div class="overlay-title">Pulau Komodo</div>
            <div class="overlay-caption">Habitat asli komodo, reptil purba satu-satunya di dunia.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/wae-rebo.jpg') }}" alt="Desa Wae Rebo">
        <div class="gallery-overlay">
            <div class="overlay-title">Desa Wae Rebo</div>
            <div class="overlay-caption">Desa tradisional dengan rumah kerucut Mbaru Niang yang unik.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/pulau-alor.jpg') }}" alt="Pulau Alor">
        <div class="gallery-overlay">
            <div class="overlay-title">Pulau Alor</div>
            <div class="overlay-caption">Destinasi menyelam kelas dunia dengan biota laut menakjubkan.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/bukit-cinta.jpg') }}" alt="Bukit Cinta">
        <div class="gallery-overlay">
            <div class="overlay-title">Bukit Cinta</div>
            <div class="overlay-caption">Tempat terbaik menikmati matahari terbenam di Labuan Bajo.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/pantai-koka.jpeg') }}" alt="Pantai Koka">
        <div class="gallery-overlay">
            <div class="overlay-title">Pantai Koka</div>
            <div class="overlay-caption">Pantai dengan pasir putih lembut diapit dua tebing alami yang megah.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/gunung-egon.jpeg') }}" alt="Gunung Egon">
        <div class="gallery-overlay">
            <div class="overlay-title">Gunung Egon</div>
            <div class="overlay-caption">Gunung aktif dengan pemandangan kawah dan panorama laut biru.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/pink-beach.jpg') }}" alt="Pink Beach">
        <div class="gallery-overlay">
            <div class="overlay-title">Pink Beach</div>
            <div class="overlay-caption">Pantai langka dengan pasir berwarna pink natural dari pecahan karang merah.</div>
        </div>
    </div>

    {{-- KULINER (10 photos) --}}
    <div class="gallery-item">
        <img src="{{ asset('images/sei-sapi.jpg') }}" alt="Se'i Sapi">
        <div class="gallery-overlay">
            <div class="overlay-title">Se'i Sapi</div>
            <div class="overlay-caption">Daging sapi asap khas Rote dengan aroma kayu bakar yang khas.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/jagung-bose.jpg') }}" alt="Jagung Bose">
        <div class="gallery-overlay">
            <div class="overlay-title">Jagung Bose</div>
            <div class="overlay-caption">Makanan pokok tradisional dari jagung putih dengan santan.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/kolo.jpg') }}" alt="Kolo">
        <div class="gallery-overlay">
            <div class="overlay-title">Kolo (Nasi Bambu)</div>
            <div class="overlay-caption">Nasi yang dimasak di dalam bambu dengan aroma harum yang unik.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/ikan-kuah-asam.jpg') }}" alt="Ikan Kuah Asam">
        <div class="gallery-overlay">
            <div class="overlay-title">Ikan Kuah Asam</div>
            <div class="overlay-caption">Ikan segar dengan kuah asam belimbing wuluh yang menyegarkan.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/rumpu-rampe.jpg') }}" alt="Rumpu Rampe">
        <div class="gallery-overlay">
            <div class="overlay-title">Rumpu Rampe</div>
            <div class="overlay-caption">Tumisan sayuran dengan bumbu rempah khas NTT yang pedas.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/catemak-jagung.jpg') }}" alt="Catemak Jagung">
        <div class="gallery-overlay">
            <div class="overlay-title">Catemak Jagung</div>
            <div class="overlay-caption">Bubur jagung khas Timor dengan kacang merah dan labu kuning.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/kohu-kohu.jpg') }}" alt="Kohu-Kohu">
        <div class="gallery-overlay">
            <div class="overlay-title">Kohu-Kohu</div>
            <div class="overlay-caption">Salad khas NTT dengan ikan asap, kelapa parut, dan jeruk nipis.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/sambal-luat.jpg') }}" alt="Sambal Lu'at">
        <div class="gallery-overlay">
            <div class="overlay-title">Sambal Lu'at</div>
            <div class="overlay-caption">Sambal khas NTT yang sangat pedas dan addictive.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/kue-jawada.jpg') }}" alt="Rote Kue">
        <div class="gallery-overlay">
            <div class="overlay-title">Kue Jawada</div>
            <div class="overlay-caption">Kue tradisional dengan gula merah dan kelapa, tekstur lembut.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/lawar-lombok.jpg') }}" alt="Lawar Lombok">
        <div class="gallery-overlay">
            <div class="overlay-title">Lawar Lombok</div>
            <div class="overlay-caption">Tumisan bunga pepaya dengan kelapa parut, pahit dan pedas.</div>
        </div>
    </div>

    {{-- EVENT (10 photos) --}}
    <div class="gallery-item">
        <img src="{{ asset('images/festival-pasola.jpg') }}" alt="Festival Pasola">
        <div class="gallery-overlay">
            <div class="overlay-title">Festival Pasola</div>
            <div class="overlay-caption">Ritual perang berkuda dengan lembing kayu, tradisi kesuburan tanah.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/festival-tenun-ikat.jpg') }}" alt="Festival Tenun Ikat">
        <div class="gallery-overlay">
            <div class="overlay-title">Festival Tenun Ikat</div>
            <div class="overlay-caption">Pameran kain tenun ikat warisan budaya tak benda UNESCO.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/festival-komodo.jpg') }}" alt="Festival Komodo">
        <div class="gallery-overlay">
            <div class="overlay-title">Festival Komodo</div>
            <div class="overlay-caption">Festival tahunan merayakan keberadaan komodo dengan budaya lokal.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/festival-likurai.jpg') }}" alt="Pajuran Kuda">
        <div class="gallery-overlay">
            <div class="overlay-title">Festival Likurai</div>
            <div class="overlay-caption">Pacuan kuda tradisional Sumba tanpa pelana untuk rayakan panen.</div>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/festival-danau-kelimutu.jpg') }}" alt="Upacara Reba">
        <div class="gallery-overlay">
            <div class="overlay-title">festival-danau-kelimutu</div>
            <div class="overlay-caption">Upacara syukuran pasca panen di Manggarai dengan tarian caci.</div>
        </div>
    </div>
</div>

<div class="gallery-stats">
    <div class="stat-card">
        <div class="stat-number">1000+</div>
        <div class="stat-label">Pulau</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">15+</div>
        <div class="stat-label">Suku Asli</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">50+</div>
        <div class="stat-label">Destinasi Wisata</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">∞</div>
        <div class="stat-label">Keindahan Alam</div>
    </div>
</div>
@endsection