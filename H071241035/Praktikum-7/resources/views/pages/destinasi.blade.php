@extends('layouts.master')

@section('content')
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8 " style="font-family: 'LontaraBugis', sans-serif;">Destinasi Wisata di Makassar</h1>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Jelajahi tempat-tempat menarik yang wajib dikunjungi saat berada di Makassar.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div id="pantai-losari">
                    <x-card
                        title="Pantai Losari"
                        description="Landmark Makassar, tempat yang sempurna untuk menikmati sunset. Aktivitas seperti berjalan-jalan, naik andong, atau mencicipi jajanan kaki lima sangat populer di sini."
                        image="{{ asset('images/pantai_losari.jpg') }}" 
                        link="https://id.wikipedia.org/wiki/Pantai_Losari"
                        link-text="Lihat Detail"
                    />
                </div>
                <div id="benteng-rotterdam">
                    <x-card
                        title="Benteng Rotterdam"
                        description="Benteng bersejarah peninggalan Belanda abad ke-16. Sekarang menjadi tempat wisata budaya dan pusat kegiatan seni serta budaya Sulawesi Selatan."
                        image="{{ asset('images/benteng_rotterdam.jpg') }}" 
                        link="https://id.wikipedia.org/wiki/Benteng_Rotterdam"
                        link-text="Lihat Detail"
                    />
                </div>
                <div id="masjid_99_kubah">
                    <x-card
                        title="Masjid 99 Kubah"
                        description="Masjid ikonik di kawasan CPI Makassar, dengan arsitektur megah yang terinspirasi oleh keindahan alam dan budaya Sulawesi Selatan."
                        image="{{ asset('images/masjid_99_kubah.jpg') }}"
                        link="https://id.wikipedia.org/wiki/Masjid_99_Kubah"
                        link-text="Lihat Detail"
                    />
                </div>
                 <!-- Tambahkan destinasi lain jika diperlukan -->
            </div>
            <br>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Masih banyak lagi di update mendatang.
            </p>
        </div>
    </section>
@endsection