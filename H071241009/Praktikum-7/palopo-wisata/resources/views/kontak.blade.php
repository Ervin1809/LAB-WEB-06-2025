@extends('layouts.master')

@section('title', 'Kontak Kami')

@section('content')
    <h2>Hubungi Kami</h2>
    <p>Silakan hubungi kami jika ada pertanyaan lebih lanjut.</p>

    <div class="contact-info">
        <p><strong>Email:</strong> info.palopo@wisata.id</p>
        <p><strong>Telepon:</strong> (0471) 123-456</p>
        <p><strong>Alamat:</strong> Jl. Merdeka No. 1, Kota Palopo, Sulawesi Selatan</p>
    </div>

    <form action="#" method="POST" class="contact-form">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="pesan">Pesan:</label>
        <textarea id="pesan" name="pesan" rows="4"></textarea>

        <button type="submit">Kirim</button>
    </form>
@endsection