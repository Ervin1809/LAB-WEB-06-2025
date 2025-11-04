<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --color-primary: #4A5D4A;
        --color-primary-dark: #3A4D3A;
        --color-secondary: #8B7355;
        --color-accent: #B85C3A;
        --color-cream: #F5F1E8;
        --color-beige: #E8DCC8;
        --color-moss: #7A9075;
        --color-earth: #A68A6D;
        --color-text: #2C2C2C;
        --color-text-light: #666666;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--color-cream);
        color: var(--color-text);
        line-height: 1.6;
    }

    .content-wrapper {
        padding: 4rem 4rem 2rem;
        max-width: 1400px;
        margin: 0 auto;
        min-height: 50vh;
    }

    .hero-section {
        margin: -2rem -2rem 0;
        position: relative;
        background-image: url('{{ asset('images/hero--enrekang.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 8rem 2rem;
        color: white;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(44, 44, 44, 0.4) 0%, rgba(74, 93, 74, 0.7) 100%);
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
        line-height: 1.2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .hero-description {
        font-size: 1.125rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 300;
        max-width: 650px;
        margin: 0 auto;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem; 
        font-weight: 700;
        color: var(--color-primary-dark);
        margin-top: 0.5rem;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
        text-align: center;  
    }

    .section-main-description {
        font-size: 1.15rem; 
        color: var(--color-text-light); 
        line-height: 1.8;
        margin: 0 auto 4rem;  
        max-width: 900px;     
        text-align: center;  
        padding: 0 2rem;
        font-weight: 300;
    }
     
    .highlights {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 0; 
    }

    .highlight-card {
        display: block; 
        text-decoration: none; 
        color: var(--color-text); 
        background-color: white;
        padding: 2rem;
        border: 1px solid var(--color-beige);
        transition: all 0.3s ease;
    }

    .highlight-card:hover { 
        border-color: var(--color-primary); 
        box-shadow: 0 8px 16px rgba(74, 93, 74, 0.1); 
    }

    .highlight-icon {
        width: 48px;
        height: 48px;
        background-color: var(--color-cream); 
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        font-size: 1.5rem;
    }

    .highlight-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text); 
        margin-bottom: 0.75rem;
    }

    .highlight-text {
        font-size: 0.9375rem;
        color: var(--color-text-light); 
        line-height: 1.7;
        font-weight: 300;
    }
 
    @media (max-width: 768px) {
        .hero-section {
            padding: 5rem 1.5rem;
            margin: -2.5rem -1.5rem 3rem;
            min-height: 60vh;
        }

        .hero-title {
            font-size: 2.25rem;
        }

        .hero-description {
            font-size: 1rem;
        }
        
        /* Main Description */
        .section-title {
            font-size: 2rem;
        }
        .section-main-description {
            font-size: 1rem;
        }

        /* Highlights (3 Cards) */
        .highlights {
            gap: 1.5rem;
        }
    }
</style>

@extends('layouts.master')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Selamat Datang di Enrekang</h1>
        <p class="hero-description">
            Temukan pesona pegunungan yang tiada tara di jantung Sulawesi Selatan. Sambut <strong>Bumi Massenrempulu</strong>—tempat di mana udara sejuk, perbukitan hijau, dan warisan budaya yang kaya menanti untuk dijelajahi.
        </p>
    </div>
</div>

<section class="content-wrapper">
    <h2 class="section-title">Jelajahi Enrekang</h2>
    
    <p class="section-main-description">
        Kabupaten Enrekang, yang merupakan permata tersembunyi di jantung Sulawesi Selatan, adalah rumah bagi sekitar 225.172 jiwa dengan ibu kota yang terletak di Kecamatan Enrekang. Dikenal dengan topografi yang didominasi oleh perbukitan dan pegunungan—mencakup hampir <strong>85% dari total luas wilayah 1.786 km²</strong>—Enrekang menawarkan pemandangan alam yang dramatis, lembah yang sejuk, dan sungai yang jernih.
        <br><br>
        Wilayah ini adalah surga bagi para pecinta alam dan petualang, karena memiliki puncak-puncak gunung ikonik yang menjulang tinggi antara 47 hingga 3.293 meter di atas permukaan laut. Di sinilah berdiri <strong>Gunung Latimojong</strong>, gunung tertinggi di seluruh Sulawesi Selatan (3.478 mdpl) yang menjadi tujuan utama pendakian, serta <strong>Gunung Bambapuang</strong> dan <strong>Gunung Sinaji</strong>.
    </p>
    </section>

    <div class="highlights">
        
        <a href="{{ url('/destinasi') }}" class="highlight-card">
            <div class="highlight-icon">🏔️</div>
            <h3 class="highlight-title">Destinasi Alam</h3>
            <p class="highlight-text">Jelajahi keindahan pegunungan, air terjun, dan pemandangan alam yang menyejukkan mata dan jiwa.</p>
        </a>
        
        <a href="{{ url('/kuliner') }}" class="highlight-card">
            <div class="highlight-icon">🍲</div>
            <h3 class="highlight-title">Kuliner Khas</h3>
            <p class="highlight-text">Nikmati cita rasa autentik masakan tradisional dengan bahan-bahan segar dari pegunungan.</p>
        </a>
        
        <a href="{{ url('/galeri') }}" class="highlight-card">
            <div class="highlight-icon">📸</div>
            <h3 class="highlight-title">Galeri Foto</h3>
            <p class="highlight-text">Abadikan momen indah di setiap sudut Enrekang yang mempesona dan penuh cerita.</p>
        </a>

    </div>
</section>

@endsection