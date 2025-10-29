@extends('layouts.master') 

@section('title', 'Event Daerah')

@section('content')
<style>
    .event-header {
    background:linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255, 235, 230, 0.9) 100%);
    color: #ff6f51;
    padding: 50px 30px;
    border-radius: 24px;
    text-align: center;
    margin-bottom: 40px;
    box-shadow: 0 8px 30px rgba(255, 140, 100, 0.20);
    position: relative;
    overflow: hidden;
    }

    .event-header::before {
        position: absolute;
        font-size: 12em;
        opacity: 0.08;
        top: -30px;
        left: -30px;
    }

    .event-header h2 {
        font-size: 2.8em;
        margin-bottom: 12px;
        font-weight: 700;
        position: relative;
        z-index: 1;
        color: #ff6f51;
    }

    .event-header p {
        font-size: 1.1em;
        max-width: 750px;
        margin: 0 auto;
        z-index: 1;
        position: relative;
        color: #000;
        opacity: 1;
    }

    .event-container {
        display: grid;
        gap: 25px;
    }

    .event-card {
        background: #ffffff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(255, 140, 100, 0.15);
        display: grid;
        grid-template-columns: 1fr 1fr;
        transition: none;
    }

    .event-image {
        position: relative;
        min-height: 350px;
        overflow: hidden;
    }

    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: none;
    }

    .event-content {
        padding: 35px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
    }

    .event-content h3 {
        color: #ff6f51;
        font-size: 1.9em;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .event-content p {
        color: #444;
        margin-bottom: 14px;
        font-size: 0.97em;
        line-height: 1.7;
    }

    .event-meta {
        display: flex;
        gap: 15px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .meta-item {
        background: #ffe2d6;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 0.9em;
        font-weight: 600;
        color: #c75b42;
    }

    @media (max-width: 968px) {
        .event-card {
            grid-template-columns: 1fr;
        }
        .event-image {
            min-height: 250px;
        }
        .event-header h2 {
            font-size: 2em;
        }
    }
</style>

<div class="event-header">
    <h2>Event dan Festival Budaya NTT</h2>
    <p>Jelajahi pesona budaya dan tradisi yang hidup di setiap sudut NTT</p>
</div>

<div class="event-container">

    {{-- Pasola --}}
    <div class="event-card">
        <div class="event-image">
            <img src="{{ asset('images/festival-pasola.jpg') }}" alt="Festival Pasola">
        </div>
        <div class="event-content">
            <h3>Festival Pasola (Sumba)</h3>
            <p>Ritual perang antar penunggang kuda sebagai wujud syukur dan doa untuk kesuburan tanah.</p>
            <div class="event-meta">
                <div class="meta-item">📅 Feb - Mar</div>
                <div class="meta-item">📍 Sumba Barat</div>
            </div>
        </div>
    </div>

    {{-- Festival Komodo --}}
    <div class="event-card">
        <div class="event-content">
            <h3>Festival Komodo</h3>
            <p>Perayaan keindahan Pulau Komodo dengan parade budaya dan atraksi wisata.</p>
            <div class="event-meta">
                <div class="meta-item">📅 Juni</div>
                <div class="meta-item">📍 Labuan Bajo</div>
            </div>
        </div>
        <div class="event-image">
            <img src="{{ asset('images/festival-komodo.jpg') }}" alt="Festival Komodo">
        </div>
    </div>

    {{-- Likurai --}}
    <div class="event-card">
        <div class="event-image">
            <img src="{{ asset('images/festival-likurai.jpg') }}" alt="Festival Likurai">
        </div>
        <div class="event-content">
            <h3>Festival Likurai</h3>
            <p>Parade tarian perang khas Belu dengan genderang dan pakaian adat.</p>
            <div class="event-meta">
                <div class="meta-item">📅 Okt - Nov</div>
                <div class="meta-item">📍 Atambua</div>
            </div>
        </div>
    </div>

    {{-- Kelimutu --}}
    <div class="event-card">
        <div class="event-content">
            <h3>Festival Danau Kelimutu</h3>
            <p>Ritual adat di Danau Tiga Warna penuh makna spiritual dan hiburan rakyat.</p>
            <div class="event-meta">
                <div class="meta-item">📅 14 Agustus</div>
                <div class="meta-item">📍 Ende</div>
            </div>
        </div>
        <div class="event-image">
            <img src="{{ asset('images/festival-danau-kelimutu.jpg') }}" alt="Festival Kelimutu">
        </div>
    </div>

    {{-- Tenun Ikat Nusantara --}}
    <div class="event-card">
        <div class="event-image">
            <img src="{{ asset('images/festival-tenun-ikat.jpg') }}" alt="Festival Tenun Ikat Nusantara">
        </div>
        <div class="event-content">
            <h3>Festival Tenun Ikat Nusantara</h3>
            <p>Pameran kain ikat khas seluruh NTT disertai fashion show dan bazar UMKM lokal.</p>
            <div class="event-meta">
                <div class="meta-item">📅 Pertengahan Tahun</div>
                <div class="meta-item">📍 Kupang</div>
            </div>
        </div>
    </div>

    {{-- Parade 1001 Kuda --}}
    <div class="event-card">
        <div class="event-content">
            <h3>Parade 1001 Kuda Sandelwood</h3>
            <p>Parade ribuan kuda Sandelwood ditunggangi penenun lokal dengan busana adat.</p>
            <div class="event-meta">
                <div class="meta-item">📅 Juni - Juli</div>
                <div class="meta-item">📍 Pulau Sumba</div>
            </div>
        </div>
        <div class="event-image">
            <img src="{{ asset('images/parade-1001-kuda.jpg') }}" alt="Parade Kuda Sandelwood">
        </div>
    </div>

</div>
@endsection
