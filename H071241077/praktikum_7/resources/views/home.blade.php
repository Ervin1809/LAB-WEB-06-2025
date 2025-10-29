@extends('layouts.master')

@section('title', 'Home')

@section('content')
<style>
    .hero-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 80px;
        padding: 40px;
        background: url('{{ asset("images/logo.png") }}') center/cover;
        border-radius: 24px;
        position: relative;
    }

    .hero-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 24px;
    }

    .hero-content {
        padding-right: 20px;
        position: relative;
        z-index: 1;
    }

    .hero-content h2 {
        color: #ff7e5f;
        font-size: 3.2em;
        margin-bottom: 30px;
        font-weight: 700;
        line-height: 1.2;
    }

    .hero-content .highlight {
        color: #ff6b6b;
        position: relative;
        display: inline-block;
    }

    .hero-description {
        color: #555;
        font-size: 1.1em;
        line-height: 1.9;
        margin-bottom: 25px;
    }

    .cta-button {
        display: inline-block;
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
        color: white;
        padding: 18px 45px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1em;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
        margin-top: 20px;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    }

    .hero-images {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .hero-image-wrapper {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(255, 126, 95, 0.15);
        transition: transform 0.4s ease;
    }

    .hero-image-wrapper:hover {
        transform: translateY(-10px) scale(1.05);
    }

    .hero-image-wrapper:nth-child(1) {
        grid-row: span 2;
    }

    .hero-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-image-wrapper:nth-child(1) img {
        height: 100%;
        min-height: 500px;
    }

    .hero-image-wrapper:nth-child(2) img,
    .hero-image-wrapper:nth-child(3) img {
        height: 240px;
    }

    .hero-image-wrapper:nth-child(2) img,
    .hero-image-wrapper:nth-child(3) img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }
    
    .plane-icon {
        position: absolute;
        bottom: 30px;
        left: -40px;
        font-size: 3em;
        animation: float 3s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(-15deg);
        }
        50% {
            transform: translateY(-20px) rotate(-15deg);
        }
    }

    .features-section {
        margin-top: 80px;
    }

    .section-title {
        text-align: center;
        color: #ff7e5f;
        font-size: 2.5em;
        margin-bottom: 50px;
        font-weight: 700;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 35px;
        margin-bottom: 60px;
    }

    .feature-card {
        background: white;
        border-radius: 24px;
        padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(255, 126, 95, 0.12);
        transition: all 0.4s ease;
        text-align: center;
        border: 2px solid transparent;
    }

    .feature-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(255, 126, 95, 0.25);
        border-color: #ff9a76;
    }

    .feature-icon {
        font-size: 4.5em;
        margin-bottom: 25px;
        display: block;
    }

    .feature-card h3 {
        color: #ff7e5f;
        font-size: 1.6em;
        margin-bottom: 18px;
        font-weight: 700;
    }

    .feature-card p {
        color: #666;
        line-height: 1.8;
        font-size: 1em;
    }

    @media (max-width: 968px) {
        .hero-container {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .hero-content h2 {
            font-size: 2.2em;
        }

        .hero-images {
            grid-template-columns: 1fr;
        }

        .hero-image-wrapper:nth-child(1) {
            grid-row: span 1;
        }

        .hero-image-wrapper:nth-child(1) img {
            min-height: 300px;
        }

        .features-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
</style>

<div class="hero-container">
    <div class="hero-content">
        <h2>Discover the World's <span class="highlight">Hidden Wonders</span></h2>
        <p class="hero-description">
            Nusa Tenggara Timur (NTT) adalah provinsi kepulauan yang menakjubkan, terkenal dengan keanekaragaman hayati, budaya, dan pemandangan alamnya yang epik. Dari komodo purba hingga danau tiga warna yang mistis, NTT menawarkan petualangan yang tak tertandingi.
        </p>
        <p class="hero-description">
            Jelajahi keindahan Flores, Sumba, Timor, dan pulau-pulau kecil lainnya yang menyimpan permata tersembunyi kuliner dan destinasi yang luar biasa.
        </p>
        <a href="{{ route('destinasi') }}" class="cta-button">Explore Now →</a>
    </div>

    <div class="hero-images">
        <div class="hero-image-wrapper">
            <img src="{{ asset('images/ntt.jpg') }}" alt="Kekayaan Alam NTT">
        </div>
        <div class="hero-image-wrapper">
            <img src="{{ asset('images/alat-musik.png') }}" alt="Alat Musik Tradisional NTT">
        </div>
        <div class="hero-image-wrapper">
            <img src="{{ asset('images/rumah-adat.jpg') }}" alt="Rumah Adat NTT">
        </div>
        <span class="plane-icon">✈️</span>
    </div>
</div>

<div class="features-section">
    <h2 class="section-title">Kenapa Harus Mengunjungi NTT?</h2>
    
    <div class="features-grid">
        <div class="feature-card">
            <span class="feature-icon">🏝️</span>
            <h3>Keindahan Alam</h3>
            <p>Dari Pink Beach hingga Nihiwatu yang memukau, dari savana Pulau Padar hingga danau tiga warna Kelimutu - NTT menawarkan panorama alam yang spektakuler dan tidak ditemukan di tempat lain.</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon">🎭</span>
            <h3>Kebudayaan Unik</h3>
            <p>Saksikan ritual Pasola, tenun ikat tradisional dengan motif filosofis, dan rumah adat megalitik yang masih lestari. Budaya NTT kaya akan tradisi dan kearifan lokal yang autentik.</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon">🍖</span>
            <h3>Kuliner Autentik</h3>
            <p>Nikmati Se'i Sapi yang beraroma khas, Jagung Bose yang gurih, dan Kolo nasi bambu yang harum. Kuliner NTT menawarkan cita rasa unik yang kaya akan tradisi dan kelezatan.</p>
        </div>

        <div class="feature-card">
            <span class="feature-icon">🛕</span>
            <h3>Sejarah Kota NTT</h3>
            <p>Telusuri jejak sejarah dari masa kolonial, arsitektur bersejarah di Kupang, hingga situs megalitik kuno di Sumba. NTT menyimpan warisan sejarah yang berharga dan menarik untuk dipelajari.</p>
        </div>
    </div>
</div>
@endsection