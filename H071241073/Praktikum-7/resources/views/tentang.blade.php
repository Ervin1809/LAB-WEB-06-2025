@extends('layouts.master')

@section('title', 'Tentang Toraja Utara')

@section('content')
<section class="px-4 md:px-0 max-w-7xl mx-auto mt-12">

    <!-- Judul -->
    <div class="text-center mb-16">
        <h2 class="text-3xl sm:text-4xl font-bold text-slate-800 drop-shadow-md">
            Mengenal Toraja Utara
        </h2>
        <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed mt-2">
            Menyelami sejarah, budaya, dan keindahan alam Toraja Utara sebuah wilayah di jantung Sulawesi Selatan yang menyimpan pesona tak tergantikan.
        </p>
    </div>

    <!-- Sejarah -->
    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
        <div class="space-y-6">
            <h3 class="text-2xl font-semibold text-slate-800">Sejarah Toraja Utara</h3>
            <p class="text-slate-700 leading-relaxed">
                Toraja Utara merupakan salah satu daerah di Sulawesi Selatan yang dikenal dengan sejarah dan kebudayaannya yang berakar kuat. 
                Nama “Toraja” sendiri berasal dari kata <em>to riaja</em>, yang berarti “orang yang berdiam di pegunungan.” 
                Masyarakat Toraja sejak dahulu hidup berdampingan dengan alam, membangun kehidupan yang sarat nilai gotong royong, kesetiaan terhadap adat, serta penghormatan tinggi kepada leluhur.
            </p>
            <p class="text-slate-700 leading-relaxed">
                Di Toraja Utara, setiap rumah adat <strong>Tongkonan</strong> bukan sekadar tempat tinggal, melainkan simbol persatuan keluarga dan sejarah panjang suatu garis keturunan. 
                Upacara adat seperti <strong>Rambu Solo'</strong> upacara pemakaman tradisional yang megah menjadi wujud penghormatan terakhir bagi orang yang telah meninggal dan juga bentuk ekspresi seni, budaya, dan spiritualitas masyarakatnya. 
                Tradisi ini telah diwariskan lintas generasi, menjadikan Toraja Utara salah satu kawasan budaya paling unik di Indonesia.
            </p>
        </div>

        <div class="flex justify-center md:justify-start">
            <img src="{{ asset('images/tentang1.jpg') }}" 
                alt="Tentang Toraja 1" 
                class="rounded-2xl shadow-xl w-4/5 translate-x-8 md:translate-x-16 aspect-4/5 object-cover 
                       rotate-2 transition-transform duration-300 hover:scale-105 hover:rotate-1">
        </div>
    </div>

    <!-- Budaya -->
    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
        <div class="space-y-6 md:order-last">
            <h3 class="text-2xl font-semibold text-slate-800">Budaya dan Tradisi</h3>
            <p class="text-slate-700 leading-relaxed">
                Budaya Toraja Utara memadukan keindahan seni, makna spiritual, dan nilai sosial yang tinggi. 
                Setiap upacara adat, tarian, hingga pahatan kayu memiliki cerita dan filosofi tersendiri. 
                Seni ukir khas Toraja yang sering terlihat pada dinding Tongkonan menggambarkan simbol kehidupan, kemakmuran, dan hubungan manusia dengan alam semesta.
            </p>
            <p class="text-slate-700 leading-relaxed">
                Selain itu, musik tradisional yang diiringi dengan alat seperti <em>pa'pompang</em> dan tarian <em>Ma'badong</em> menjadi bagian penting dalam setiap perayaan adat. 
                Melalui tradisi dan karya seni ini, masyarakat Toraja Utara terus menjaga jati diri mereka sekaligus memperkenalkan warisan budaya luhur kepada dunia.
            </p>
        </div>

        <div class="flex justify-center md:justify-end">
            <img src="{{ asset('images/tentang2.jpg') }}" 
                alt="Tentang Toraja 2" 
                class="rounded-2xl shadow-xl w-4/5 -translate-x-8 md:-translate-x-16 aspect-4/5 object-cover 
                       -rotate-3 transition-transform duration-300 hover:scale-105 hover:rotate-0">
        </div>
    </div>

    <!-- Alam -->
    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
        <div class="space-y-6">
            <h3 class="text-2xl font-semibold text-slate-800">Keindahan Alam</h3>
            <p class="text-slate-700 leading-relaxed">
                Keindahan alam Toraja Utara menjadi pelengkap sempurna dari kekayaan budayanya. 
                Hamparan pegunungan hijau, lembah yang subur, dan sawah berterasering menciptakan pemandangan yang menenangkan mata. 
                Di pagi hari, kabut tipis yang menyelimuti perbukitan menghadirkan suasana magis yang sulit ditemukan di tempat lain.
            </p>
            <p class="text-slate-700 leading-relaxed">
                Beberapa destinasi alam seperti <strong>Negeri di Atas Awan Lolai</strong>, <strong>Kete Kesu'</strong>, dan <strong>Lokomata</strong> menjadi magnet bagi para wisatawan lokal maupun mancanegara. 
                Tak hanya menawarkan keindahan visual, tempat-tempat ini juga menyuguhkan ketenangan yang membuat setiap pengunjung merasa lebih dekat dengan alam dan kehidupan yang sederhana.
            </p>
        </div>

        <div class="flex justify-center md:justify-start">
            <img src="{{ asset('images/tentang3.jpg') }}" 
                alt="Tentang Toraja 3" 
                class="rounded-2xl shadow-xl w-4/5 translate-x-8 md:translate-x-16 aspect-4/5 object-cover 
                       rotate-1 transition-transform duration-300 hover:scale-105 hover:rotate-0">
        </div>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-2xl text-slate-700">
        <p class="text-lg leading-relaxed">
            Toraja Utara bukan hanya kaya akan budaya dan tradisi, tetapi juga menyimpan pesona alam serta cita rasa kuliner yang khas. 
            Melalui <strong>Explore Toraja Utara</strong>, mari lanjutkan perjalanan Anda untuk mengenal lebih dekat 
            <a href="{{ route('destinasi') }}" class="text-blue-600 font-semibold hover:underline">destinasi wisata</a> 
            dan menikmati <a href="{{ route('kuliner') }}" class="text-blue-600 font-semibold hover:underline">kuliner lokal</a> 
            yang menjadi kebanggaan masyarakat Toraja.
        </p>
    </div>

</section>
@endsection
