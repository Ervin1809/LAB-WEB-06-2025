@extends('layouts.master')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-4xl text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900">
                Hubungi Kami
            </h1>
            <p class="mt-3 text-gray-600">
                Punya pertanyaan atau ingin berkontribusi? Silakan hubungi kami.
            </p>
        </div>

        <div class="mx-auto max-w-6xl grid grid-cols-1 md:grid-cols-5 gap-6">
            {{-- Panel Info Kontak --}}
            <div class="md:col-span-2">
                <div class="h-full rounded-2xl border border-gray-100 bg-white/80 backdrop-blur shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                                {{-- Heroicon: Envelope --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 7.5v9A2.25 2.25 0 0 1 19.5 18.75h-15A2.25 2.25 0 0 1 2.25 16.5v-9M21.75 7.5l-9.27 6.18a2.25 2.25 0 0 1-2.46 0L.75 7.5m21 0A2.25 2.25 0 0 0 19.5 5.25h-15A2.25 2.25 0 0 0 2.25 7.5"/>
                                </svg>
                            </span>
                            <div class="leading-6">
                                <div class="text-sm text-gray-500">Email</div>
                                <div class="font-medium text-gray-900">info@beutifulmakassar.id</div>
                                {{-- Jika ini typo, ganti ke beautifulmakassar.id --}}
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                                {{-- Heroicon: Phone --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.05a1.5 1.5 0 0 0-1.065-1.44l-3.21-1.07a1.5 1.5 0 0 0-1.536.36l-.99.99a12.06 12.06 0 0 1-5.37-5.37l.99-.99a1.5 1.5 0 0 0 .36-1.536l-1.07-3.21A1.5 1.5 0 0 0 6.6 3.75H5.55A2.25 2.25 0 0 0 3.3 6v.75z"/>
                                </svg>
                            </span>
                            <div class="leading-6">
                                <div class="text-sm text-gray-500">Telepon</div>
                                <div class="font-medium text-gray-900">+62 411 123 4567</div>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                                {{-- Heroicon: Map Pin --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM12 21s7.5-5.1 7.5-10.5A7.5 7.5 0 0 0 12 3a7.5 7.5 0 0 0-7.5 7.5C4.5 15.9 12 21 12 21z"/>
                                </svg>
                            </span>
                            <div class="leading-6">
                                <div class="text-sm text-gray-500">Lokasi</div>
                                <div class="font-medium text-gray-900">Kota Makassar, Sulawesi Selatan, Indonesia</div>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-8 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border border-blue-100">
                        <p class="text-sm text-blue-700">
                            Balas cepat di jam kerja Senin–Jumat, 09.00–17.00 WITA.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div class="md:col-span-3">
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Kirim Pesan</h2>
                    <form>
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input
                                    id="name" name="name" type="text" placeholder="Nama Anda"
                                    class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 px-4 py-2.5 transition"
                                >
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input
                                    id="email" name="email" type="email" placeholder="nama@email.com"
                                    class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 px-4 py-2.5 transition"
                                >
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea
                                id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini…"
                                class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 px-4 py-2.5 transition resize-y"
                            ></textarea>
                        </div>

                        <div class="mt-6">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-white font-semibold shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue-200 active:bg-blue-800 transition"
                            >
                                Kirim Pesan
                            </button>
                        </div>

                        <p class="mt-3 text-xs text-gray-500">
                            Dengan mengirim pesan, Anda setuju terhadap ketentuan komunikasi kami.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
