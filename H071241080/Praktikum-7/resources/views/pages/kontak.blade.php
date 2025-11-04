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

    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 4rem;
        margin-top: 3rem;
    }

    .contact-info {
        background-color: #F5F1E8;
        padding: 2.5rem;
        border: 1px solid #E8DCC8;
    }

    .info-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #2C2C2C;
        margin-bottom: 2rem;
        letter-spacing: -0.3px;
    }

    .info-list {
        list-style: none;
        padding: 0;
    }

    .info-item {
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.125rem;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.8125rem;
        color: #666666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .info-text {
        font-size: 0.9375rem;
        color: #2C2C2C;
        font-weight: 400;
    }

    .contact-form {
        background-color: white;
        padding: 2.5rem;
        border: 1px solid #E8DCC8;
    }

    .form-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #2C2C2C;
        margin-bottom: 2rem;
        letter-spacing: -0.3px;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #2C2C2C;
        margin-bottom: 0.5rem;
        letter-spacing: 0.3px;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 0.9375rem;
        font-family: 'Inter', sans-serif;
        color: #2C2C2C;
        background-color: #F5F1E8;
        border: 1px solid #E8DCC8;
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #4A5D4A;
        background-color: white;
    }

    .form-textarea {
        resize: vertical;
        min-height: 140px;
    }

    .form-button {
        padding: 1rem 2.5rem;
        font-size: 0.9375rem;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: white;
        background-color: #4A5D4A;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }

    .form-button:hover {
        background-color: #3A4D3A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 93, 74, 0.2);
    }

    @media (max-width: 968px) {
        .contact-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .page-title {
            font-size: 2rem;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Hubungi Kami</h1>
    <p class="page-intro">
        Anda bisa menghubungi kami untuk informasi lebih lanjut tentang wisata Enrekang. Tim kami siap membantu merencanakan perjalanan Anda.
    </p>
</div>

<div class="contact-container">
    <div class="contact-info">
        <h2 class="info-title">Informasi Kontak</h2>
        <ul class="info-list">
            <li class="info-item">
                <div class="info-icon">📧</div>
                <div class="info-content">
                    <div class="info-label">Email</div>
                    <div class="info-text">info@enrekangtour.com</div>
                </div>
            </li>
            <li class="info-item">
                <div class="info-icon">📞</div>
                <div class="info-content">
                    <div class="info-label">Telepon</div>
                    <div class="info-text">(0420) 123-4567</div>
                </div>
            </li>
            <li class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-content">
                    <div class="info-label">Alamat</div>
                    <div class="info-text">Dinas Pariwisata Kabupaten Enrekang<br>Sulawesi Selatan, Indonesia</div>
                </div>
            </li>
            <li class="info-item">
                <div class="info-icon">🕒</div>
                <div class="info-content">
                    <div class="info-label">Jam Operasional</div>
                    <div class="info-text">Senin - Jumat: 08.00 - 16.00 WITA</div>
                </div>
            </li>
        </ul>
    </div>

    <div class="contact-form">
        <h2 class="form-title">Kirim Pesan</h2>
        <form>
            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama Anda">
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com">
            </div>
            
            <div class="form-group">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea id="pesan" name="pesan" class="form-textarea" placeholder="Tulis pesan Anda di sini"></textarea>
            </div>
            
            <button type="submit" class="form-button">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection