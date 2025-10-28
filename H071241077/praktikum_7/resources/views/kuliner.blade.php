@extends('layouts.master')

@section('title', 'Kuliner Khas')

@section('content')
<style>
    .kuliner-hero {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255, 235, 230, 0.9) 100%);
        color: white;
        padding: 60px 40px;
        border-radius: 24px;
        text-align: center;
        margin-bottom: 50px;
        box-shadow: 0 12px 40px rgba(255, 126, 95, 0.3);
        position: relative;
        overflow: hidden;
    }

    .kuliner-hero::before {
        position: absolute;
        font-size: 15em;
        opacity: 0.1;
        top: -50px;
        right: -50px;
        transform: rotate(-15deg);
    }

    .kuliner-hero h2 {
    font-size: 3em;
    margin-bottom: 20px;
    font-weight: 700;
    position: relative;
    z-index: 1;
    color: #ff7e5f; 
    }

    .kuliner-hero p {
    font-size: 1.2em;
    opacity: 0.95;
    position: relative;
    z-index: 1;
    color: black;
    }

    .kuliner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .kuliner-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(255, 126, 95, 0.15);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
    }

    .kuliner-card:hover {
        transform: translateY(-12px) rotate(1deg);
        box-shadow: 0 20px 50px rgba(255, 126, 95, 0.3);
    }

    .kuliner-card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3/4;
    }

    .kuliner-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .kuliner-card:hover img {
        transform: scale(1.15) rotate(2deg);
    }

    .kuliner-card-content {
        padding: 20px;
        background: linear-gradient(to bottom, #ffffff 0%, #fff8f8 100%);
    }

    .kuliner-card h3 {
        color: #ff7e5f;
        font-size: 1.4em;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .kuliner-card p {
        color: #555;
        line-height: 1.6;
        font-size: 0.9em;
        margin-bottom: 12px;
    }

    .kuliner-tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tag {
        background: linear-gradient(135deg, #ffe5d9 0%, #ffd4c4 100%);
        color: #ff7e5f;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.75em;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .kuliner-hero h2 {
            font-size: 2em;
        }

        .kuliner-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
    }
</style>

<div class="kuliner-hero">
    <h2>Kuliner Khas NTT yang Wajib Dicoba</h2>
    <p>Rasakan cita rasa autentik Nusantara yang kaya tradisi dan penuh kelezatan!</p>
</div>

<div class="kuliner-grid">
    {{-- Kuliner 1: Se'i Sapi --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/sei-sapi.jpg') }}" alt="Se'i Sapi">
        </div>
        <div class="kuliner-card-content">
            <h3>Se'i Sapi</h3>
            <p>Daging sapi asap khas Rote dengan proses pengasapan menggunakan kayu bakar. Disajikan dengan sambal lu'at yang pedas.</p>
            <div class="kuliner-tags">
                <span class="tag">🥩 Daging</span>
                <span class="tag">🔥 Diasap</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 2: Jagung Bose --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/jagung-bose.jpg') }}" alt="Jagung Bose">
        </div>
        <div class="kuliner-card-content">
            <h3>Jagung Bose</h3>
            <p>Makanan pokok dari jagung putih yang dimasak dengan kacang dan santan hingga lembut dan mengenyangkan.</p>
            <div class="kuliner-tags">
                <span class="tag">🌽 Jagung</span>
                <span class="tag">🥥 Santan</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 3: Kolo --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/kolo.jpg') }}" alt="Kolo">
        </div>
        <div class="kuliner-card-content">
            <h3>Kolo (Nasi Bambu)</h3>
            <p>Nasi yang dimasak di dalam bambu muda menghasilkan aroma bambu yang harum dan rasa yang unik.</p>
            <div class="kuliner-tags">
                <span class="tag">🍚 Nasi</span>
                <span class="tag">🎋 Bambu</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 4: Ikan Kuah Asam --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/ikan-kuah-asam.jpg') }}" alt="Ikan Kuah Asam">
        </div>
        <div class="kuliner-card-content">
            <h3>Ikan Kuah Asam</h3>
            <p>Ikan segar dimasak dengan kuah asam dari belimbing wuluh, memberikan rasa segar dan menggugah selera.</p>
            <div class="kuliner-tags">
                <span class="tag">🐟 Ikan</span>
                <span class="tag">🍋 Asam</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 5: Rumpu Rampe --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/rumpu-rampe.jpg') }}" alt="Rumpu Rampe">
        </div>
        <div class="kuliner-card-content">
            <h3>Rumpu Rampe</h3>
            <p>Tumisan berbagai jenis sayuran dengan bumbu rempah khas NTT yang pedas dan harum.</p>
            <div class="kuliner-tags">
                <span class="tag">🥬 Sayur</span>
                <span class="tag">🌶️ Pedas</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 6: Catemak Jagung --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/catemak-jagung.jpg') }}" alt="Catemak Jagung">
        </div>
        <div class="kuliner-card-content">
            <h3>Catemak Jagung</h3>
            <p>Bubur jagung khas Timor dengan kacang merah, labu kuning, dan sayuran. Sangat mengenyangkan.</p>
            <div class="kuliner-tags">
                <span class="tag">🌽 Jagung</span>
                <span class="tag">🫘 Kacang</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 7: Kohu-Kohu --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/kohu-kohu.jpg') }}" alt="Kohu-Kohu">
        </div>
        <div class="kuliner-card-content">
            <h3>Kohu-Kohu</h3>
            <p>Salad khas NTT dengan kacang panjang, ikan asap, kelapa parut, dan jeruk nipis yang menyegarkan.</p>
            <div class="kuliner-tags">
                <span class="tag">🥗 Salad</span>
                <span class="tag">🐟 Ikan</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 8: Sambal Lu'at --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/sambal-luat.jpg') }}" alt="Sambal Lu'at">
        </div>
        <div class="kuliner-card-content">
            <h3>Sambal Lu'at</h3>
            <p>Sambal khas NTT dengan cabai rawit, tomat, dan terasi yang diulek kasar. Sangat pedas dan addictive.</p>
            <div class="kuliner-tags">
                <span class="tag">🌶️ Sambal</span>
                <span class="tag">🔥 Pedas</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 9: Kue Jawada --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/kue-jawada.jpg') }}" alt="Rote Kue">
        </div>
        <div class="kuliner-card-content">
            <h3>Kue Jawada</h3>
            <p>Kue Jawada adalah kue tradisional khas NTT berbentuk segitiga dengan tekstur renyah, terbuat dari tepung beras, gula merah, dan santan.</p>
            <div class="kuliner-tags">
                <span class="tag">🍰 Kue</span>
                <span class="tag">🍯 Manis</span>
            </div>
        </div>
    </div>

    {{-- Kuliner 10: Lawar Lombok --}}
    <div class="kuliner-card">
        <div class="kuliner-card-image">
            <img src="{{ asset('images/lawar-lombok.jpg') }}" alt="Lawar Lombok">
        </div>
        <div class="kuliner-card-content">
            <h3>Lawar Lombok</h3>
            <p>Tumisan bunga pepaya dengan kelapa parut dan cabai rawit. Pahit, pedas, dan gurih dalam satu gigitan.</p>
            <div class="kuliner-tags">
                <span class="tag">🥬 Sayur</span>
                <span class="tag">🌶️ Pedas</span>
            </div>
        </div>
    </div>
</div>
@endsection