@extends('layouts.master')

@section('content')
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8 " style="font-family: 'LontaraBugis', sans-serif;">Kuliner Khas Makassar</h1>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Nikmati kelezatan makanan dan minuman tradisional yang menjadi ciri khas kota Makassar.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-card
                    title="Coto Makassar"
                    description="Sup gurih berbahan dasar daging sapi atau kerbau, disajikan dengan ketupat dan bumbu kacang yang khas."
                    image="{{ asset('images/coto_makassar.jpg') }}" 
                    link="#"
                    link-text="Resep"
                />
                <x-card
                    title="Es Pisang Ijo"
                    description="Hidangan penutup khas Makassar yang menyegarkan, terdiri dari pisang berbalut adonan hijau, disajikan dengan saus santan, sirup merah, dan es serut."
                    image="{{ asset('images/es_pisang_ijo.jpg') }}" 
                    link="#"
                    link-text="Resep"
                />
                <x-card
                    title="Pisang Epe"
                    description="Pisang bakar manis yang disajikan dengan saus karamel gula merah dan es krim. Jajanan legendaris yang wajib dicoba."
                    image="{{ asset('images/pisang_epe.jpg') }}" 
                    link="#"
                    link-text="Resep"
                />
                <!-- Tambahkan kuliner lain jika diperlukan -->
            </div>
            <br>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Masih banyak lagi di update mendatang.
            </p>
        </div>
    </section>
@endsection