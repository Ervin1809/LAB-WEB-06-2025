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

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Cita Rasa Bumi Massenrempulu: Warisan Kuliner Enrekang</h1>
    <p class="page-intro">
        Jelajahi kelezatan khas yang lahir dari kekayaan alam pegunungan. Dari keju tradisional <strong>Dangke</strong> hingga <strong>Kopi Kalosi</strong> yang mendunia, nikmati setiap hidangan otentik yang diolah dengan resep turun temurun.
    </p>
</div>

<div class="card-grid">
    <x-card 
        title="Dangke" 
        image="{{ asset('images/kuliner-images/dangke1.jpg') }}"
        description="Keju tradisional khas Enrekang, dibuat dari susu kerbau atau sapi yang digumpalkan dengan getah pepaya. Teksturnya kenyal, rasanya gurih seperti keju, dan sering dijadikan oleh-oleh wajib."
    />

    <x-card 
        title="Pulu Mandoti" 
        image="{{ asset('images/kuliner-images/pulumandoti1.jpg') }}"
        description="Beras ketan wangi endemik dari Kecamatan Baraka. Dijuluki 'Mandoti' karena aromanya yang sangat harum. Teksturnya pulen, sering diolah menjadi sokko' untuk acara penting dan tamu kehormatan."
    />

    <x-card 
        title="Deppa Tetekan" 
        image="{{ asset('images/kuliner-images/deppatetekan1.jpg') }}"
        description="Kue manis khas Enrekang yang terbuat dari tepung beras dan gula merah dengan taburan wijen. Memiliki tekstur luar yang garing namun tetap lembut di dalam. Wajib dicoba sebagai buah tangan."
    />

    <x-card 
        title="Nasu Cemba" 
        image="{{ asset('images/kuliner-images/nasucemba2.jpg') }}"
        description="Masakan iga sapi khas masyarakat Duri Enrekang, mirip sup konro. Bahan utama dimasak hingga empuk dengan bumbu rahasia dari Daun Cemba, tumbuhan endemik yang memberikan cita rasa unik."
    />

    <x-card 
        title="Kopi Arabika Enrekang" 
        image="{{ asset('images/kuliner-images/kopikalosi1.jpg') }}"
        description="Kopi Arabika khas dengan profil rasa unik, dominan cokelat, keasaman rendah, dan rasa manis tinggi. Dikenal juga sebagai Kopi Kalosi, ia memiliki aroma kompleks seperti rempah, buah, dan bunga."
    />

    <x-card 
        title="Baje'" 
        image="{{ asset('images/kuliner-images/baje2.jpg') }}"
        description="Jajanan manis tradisional sejenis jenang gula merah yang khas. Dibuat dengan isian Beras, Ba'tan, atau Kacang, dan dibungkus unik menggunakan kulit jagung kering."
    />
</div>
@endsection