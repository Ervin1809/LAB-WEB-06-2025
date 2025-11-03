@extends('layouts.master')

@section('page-id', 'kuliner')
@section('title', 'Kuliner Khas')

@section('content')
    <h2 class="kuliner-title">Kuliner Khas Banten</h2>

    <div class="kuliner-carousel-container">
        <div class="kuliner-carousel-track">

            <x-card title="Sate Bandeng" image="images/sateBandeng.jpg" class="kuliner-carousel-item">
                Sate khas Banten yang terbuat dari daging ikan bandeng tanpa duri yang dihaluskan,
                dicampur bumbu rempah kaya rasa, lalu dibakar dalam bilah bambu.
            </x-card>

            <x-card title="Nasi Rabeg" image="images/rabeg.jpg" class="kuliner-carousel-item">
                Hidangan daging kambing atau sapi yang dimasak dengan bumbu rempah khas Banten
                yang kuat dan sedikit pedas. Mirip semur namun lebih kaya rasa.
            </x-card>

            <x-card title="Ketan Bintul" image="images/ketan-bintul.jpg" class="kuliner-carousel-item">
                Kudapan tradisional berupa ketan yang ditumbuk halus, disajikan dengan taburan
                serundeng kelapa pedas manis dan terkadang empal daging.
            </x-card>

            <x-card title="Sambal Buroq" image="images/sambalBuroq.avif" class="kuliner-carousel-item">
                 Sambal khas Serang yang unik karena menggunakan kulit melinjo (tangkil) sebagai bahan utamanya,
                 dimasak dengan cabai dan rempah lainnya. Rasanya pedas sedikit pahit.
            </x-card>

            {{-- 5 Makanan Tambahan --}}
            <x-card title="Pecak Bandeng" image="images/pecakBandeng.jpeg" class="kuliner-carousel-item">
                Ikan bandeng goreng atau bakar yang disiram dengan sambal pecak pedas segar yang terbuat dari cabai, tomat, bawang, dan terkadang kacang.
            </x-card>

            <x-card title="Kue Pasung" image="images/Kuepasung.jpg" class="kuliner-carousel-item">
                Kue tradisional berbentuk kerucut (pasung) dari daun pisang, terbuat dari tepung beras, santan, dan gula merah. Rasanya manis dan legit.
            </x-card>

            <x-card title="Angeun Lada" image="images/AngeunLada.jpg" class="kuliner-carousel-item">
                Sayur berkuah santan kental khas Pandeglang yang kaya rempah dan pedas ('lada'). Biasanya berisi daging sapi atau kerbau dan terkadang jeroan.
            </x-card>

            <x-card title="Sate Bebek" image="images/sateBebek.jpg" class="kuliner-carousel-item">
                Sate khas Cibeber, Cilegon, yang terbuat dari daging bebek empuk yang dibumbui rempah sebelum dibakar. Disajikan dengan bumbu kacang atau kecap.
            </x-card>

            <x-card title="Gerem Asem" image="images/GeremAsem.jpg" class="kuliner-carousel-item">
                Masakan berkuah asam pedas khas Cilegon, biasanya menggunakan daging ayam atau bebek yang dimasak dengan bumbu seperti belimbing wuluh dan cabai.
            </x-card>
            {{-- Akhir Makanan Tambahan --}}

        </div>
    </div>
@endsection