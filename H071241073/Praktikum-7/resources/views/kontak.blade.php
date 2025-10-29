@extends('layouts.master')

@section('title', 'Kontak Kami')

@section('content')
<h2 class="text-4xl font-bold mb-4 pb-2 border-b-4 border-yellow-500 text-center drop-shadow-md">
    Hubungi Kami
</h2>
<p class="text-lg text-gray-700 leading-relaxed mb-10 text-center max-w-3xl mx-auto">
    Kami senang mendengar dari Anda! Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau lewat kontak resmi yang tersedia.
</p>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

    <!-- Informasi Kontak -->
    <div class="bg-gradient-to-br from-yellow-50 via-white to-yellow-100 rounded-2xl shadow-lg p-8 border border-yellow-200">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-info-circle text-yellow-500"></i> Informasi Kontak
        </h3>

        <div class="space-y-5 text-gray-700">
            <p class="flex items-start gap-3">
                <span class="text-1xl">📍</span>
                <span>
                    <span class="font-semibold">Alamat:</span><br>
                    Jl. Poros Rantepao - Tallunglipu, Toraja Utara, Sulawesi Selatan
                </span>
            </p>

            <p class="flex items-start gap-3">
                <span class="text-1xl">📞</span>
                <span>
                    <span class="font-semibold">Telepon:</span><br>
                    <a href="tel:+6281234567890" class="text-yellow-600 hover:underline">+62 812-3456-7890</a>
                </span>
            </p>

            <p class="flex items-start gap-3">
                <span class="text-1xl">📧</span>
                <span>
                    <span class="font-semibold">Email:</span><br>
                    <a href="mailto:info@eksplortorajautara.com" class="text-yellow-600 hover:underline">
                        eksplortorajautara@gmail.com
                    </a>
                </span>
            </p>

            <div class="space-y-3">
                <p class="flex items-center gap-3">
                    <span class="text-1xl">📘</span>
                    <span>
                        <span class="font-semibold">Facebook:</span><br>
                        <a href="https://www.facebook.com/exploretorajautara" class="text-yellow-600 hover:underline">@eksplortorajautara</a>
                    </span>
                </p>

                <p class="flex items-center gap-3">
                    <span class="text-1xl">📸</span>
                    <span>
                        <span class="font-semibold">Instagram:</span><br>
                        <a href="https://www.instagram.com/torajautaraexplore" class="text-yellow-600 hover:underline">@torajautaraexplore</a>
                    </span>
                </p>

                <p class="flex items-center gap-3">
                    <span class="text 1xl">🐦</span>
                    <span>
                        <span class="font-semibold">Twitter (X):</span><br>
                        <a href="https://x.com/exploretorut" class="text-yellow-600 hover:underline">@visit_toraja</a>
                    </span>
                </p>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-8">
            <iframe 
                src="https://www.google.com/maps?q=Toraja+Utara&output=embed" 
                class="w-full h-60 rounded-xl shadow-md border border-gray-200">
            </iframe>
        </div>
    </div>

    <!-- Form Kontak -->
    <div class="bg-gradient-to-b from-white to-yellow-50 p-10 rounded-2xl shadow-xl border border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
            Kirim Pesan
        </h3>

        <form action="#" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama Anda"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            </div>

            <div>
                <label for="email" class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="contoh@email.com"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            </div>

            <div>
                <label for="subject" class="block font-medium text-gray-700 mb-1">Subjek</label>
                <input type="text" id="subject" name="subject" placeholder="Judul pesan"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            </div>

            <div>
                <label for="message" class="block font-medium text-gray-700 mb-1">Pesan</label>
                <textarea id="message" name="message" rows="4" placeholder="Tulis pesan Anda di sini..."
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-10 rounded-full shadow-lg transition transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
