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

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        background-color: #E8DCC8;
        aspect-ratio: 4/3;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(0.98);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(44, 44, 44, 0.7) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-caption {
        color: white;
        font-size: 0.9375rem;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Galeri Visual Bumi Massenrempulu</h1>
    <p class="page-intro">
        Sebuah koleksi gambar yang merekam keajaiban alam, kehangatan budaya, dan ikon-ikon kebanggaan Enrekang. Biarkan mata Anda menjelajahi keindahan yang menanti di setiap bingkai.
    </p>
</div>

<div class="gallery-grid">
    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/latimojong2.jpg') }}" alt="Pemandangan Pegunungan Enrekang">
        <div class="gallery-overlay">
            <span class="gallery-caption">Panorama Pegunungan</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/budaya1.jpg') }}" alt="Kehidupan Masyarakat Lokal">
        <div class="gallery-overlay">
            <span class="gallery-caption">Budaya Massenrempulu</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/latimojong3.jpg') }}" alt="Hutan Lumut di Gunung Latimojong">
        <div class="gallery-overlay">
            <span class="gallery-caption">Hutan Lumut Latimojong</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/sawah1.jpg') }}" alt="Persawahan Terasering">
        <div class="gallery-overlay">
            <span class="gallery-caption">Terasering Hijau</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/latimojong4.jpg') }}" alt="Puncak Gunung Latimojong">
        <div class="gallery-overlay">
            <span class="gallery-caption">Puncak Rante Mario</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/gunungnona2.jpg') }}" alt="Gunung Nona">
        <div class="gallery-overlay">
            <span class="gallery-caption">Ikon Gunung Nona</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/sunrise1.jpg') }}" alt="Kabut Pagi di Pegunungan">
        <div class="gallery-overlay">
            <span class="gallery-caption">Kabut Pagi</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/kadingeh1.jpg') }}" alt="Makam Tua Manduk Patinna di Desa Kadingeh">
        <div class="gallery-overlay">
            <span class="gallery-caption">Makam Tua Manduk Patinna</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/desa1.jpg') }}" alt="Desa Tradisional">
        <div class="gallery-overlay">
            <span class="gallery-caption">Desa Tradisional</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/sunset1.jpg') }}" alt="Sunrise di Puncak Bambapuang">
        <div class="gallery-overlay">
            <span class="gallery-caption">Sunset Bambapuang</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/kebunbawang1.jpg') }}" alt="Kebun Bawang di Enrekang">
        <div class="gallery-overlay">
            <span class="gallery-caption">Perkebunan Bawang di Malam Hari</span>
        </div>
    </div>

    <div class="gallery-item">
        <img src="{{ asset('images/galeri-images/gunungbatu1.jpg') }}" alt="Gunung Batu">
        <div class="gallery-overlay">
            <span class="gallery-caption">Gunung Batu</span>
        </div>
    </div>

</div>
@endsection