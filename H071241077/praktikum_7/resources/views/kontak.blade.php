@extends('layouts.master')

@section('title', 'Kontak')

@section('content')
<style>
    .kontak-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .kontak-hero {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 60px 40px;
        border-radius: 24px;
        text-align: center;
        margin-bottom: 50px;
        box-shadow: 0 12px 40px rgba(44, 62, 80, 0.3);
        position: relative;
        overflow: hidden;
    }

    .kontak-hero::before {
        content: '📞';
        position: absolute;
        font-size: 15em;
        opacity: 0.1;
        top: -50px;
        left: -50px;
    }

    .kontak-hero h2 {
        font-size: 3em;
        margin-bottom: 15px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .kontak-hero p {
        font-size: 1.2em;
        opacity: 0.95;
        position: relative;
        z-index: 1;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .kontak-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 50px;
    }

    .info-section {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 12px 35px rgba(0, 105, 92, 0.12);
    }

    .info-section h3 {
        color: #00695c;
        font-size: 2em;
        margin-bottom: 30px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: linear-gradient(135deg, #f8fffe 0%, #e0f7f4 100%);
        border-radius: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border-left: 4px solid #00897b;
    }

    .contact-item:hover {
        transform: translateX(10px);
        box-shadow: 0 8px 25px rgba(0, 137, 123, 0.2);
    }

    .contact-icon {
        font-size: 2.5em;
        min-width: 60px;
        text-align: center;
    }

    .contact-details h4 {
        color: #00695c;
        font-size: 1.2em;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .contact-details p {
        color: #555;
        font-size: 1.05em;
    }

    .form-section {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 12px 35px rgba(44, 62, 80, 0.12);
    }

    .form-section h3 {
        color: #2c3e50;
        font-size: 2em;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .form-subtitle {
        color: #666;
        font-size: 1em;
        margin-bottom: 30px;
        font-style: italic;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.05em;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 16px;
        border: 2px solid #e0f7f4;
        border-radius: 12px;
        font-size: 1em;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #00897b;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 137, 123, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }

    .submit-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #f9ca24 0%, #f0932b 100%);
        color: #2c3e50;
        border: none;
        border-radius: 12px;
        font-size: 1.15em;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(249, 202, 36, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(249, 202, 36, 0.4);
        background: linear-gradient(135deg, #f0932b 0%, #f9ca24 100%);
    }

    .submit-btn:active {
        transform: translateY(-1px);
    }

    @media (max-width: 968px) {
        .kontak-grid {
            grid-template-columns: 1fr;
        }

        .kontak-hero h2 {
            font-size: 2em;
        }

        .info-section,
        .form-section {
            padding: 30px 25px;
        }
    }
</style>

<div class="kontak-container">
    <div class="kontak-hero">
        <h2>Hubungi Kami 📞</h2>
        <p>Jika Anda memiliki pertanyaan seputar pariwisata NTT, silakan hubungi kami atau isi formulir di bawah ini</p>
    </div>

    <div class="kontak-grid">
        <div class="info-section">
            <h3>📍 Informasi Kontak</h3>
            
            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <div class="contact-details">
                    <h4>Email</h4>
                    <p>info@eksplorntt.com</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📱</div>
                <div class="contact-details">
                    <h4>Telepon</h4>
                    <p>(0380) 123456</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">🏢</div>
                <div class="contact-details">
                    <h4>Alamat Kantor</h4>
                    <p>Jl. W.J. Lalamentik No. 1<br>Kupang, Nusa Tenggara Timur</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">🕐</div>
                <div class="contact-details">
                    <h4>Jam Operasional</h4>
                    <p>Senin - Jumat: 08.00 - 17.00 WITA<br>Sabtu: 08.00 - 14.00 WITA</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">🌐</div>
                <div class="contact-details">
                    <h4>Media Sosial</h4>
                    <p>@eksplorntt (Instagram, Twitter, Facebook)</p>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Kirim Pesan Anda</h3>
            <p class="form-subtitle">*Formulir demonstrasi (tidak berfungsi)</p>
            
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                </div>
                
                <div class="form-group">
                    <label for="pesan">Pesan Anda</label>
                    <textarea id="pesan" name="pesan" placeholder="Tuliskan pertanyaan atau pesan Anda di sini..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Kirim Pesan</button>
            </form>
        </div>
    </div>
@endsection