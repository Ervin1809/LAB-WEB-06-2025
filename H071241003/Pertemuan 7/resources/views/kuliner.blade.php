@extends('template.master')
@section('title','Kuliner')

@section('content')
  {{-- overlay kontras --}}
  <div class="fixed inset-0 bg-black/30 pointer-events-none -z-10"></div>

  <section class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <header class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight">Kuliner Unggulan</h1>
      <p class="text-white/70 mt-2">Tiga kuliner andalan Majene. Foto bagus, Otentik, dan Murah.</p>
    </header>

    @php(
        $kuliner = [
      [
        'title' => 'Jepa Mandar',
        'desc'  => 'Roti pipih khas Mandar yang terbuat dari parutan singkong dan sedikit garam, kemudian dibakar di atas cetakan tanah liat. Teksturnya kenyal di luar dan lembut di dalam. Biasanya disajikan bersama ikan asin atau sambal tomat pedas.',
        'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs6oBR6rQDajSlmyMpBRj9NjSS7N0j5W4ejg&s',
        'url'   => '#'
      ],
      [
        'title' => 'Bau Tappi’ Khas Mandar',
        'desc'  => 'Ikan segar hasil tangkapan nelayan Majene dibumbui sederhana dengan garam, jeruk nipis, dan sedikit sambal mentah, lalu dibakar di atas bara kelapa. Dihidangkan bersama nasi hangat dan sambal rica khas pesisir.',
        'img'   => 'https://img-global.cpcdn.com/recipes/7da5d9880eb4c8bf/1200x630cq80/photo.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Pallu Peca’',
        'desc'  => 'Hidangan ikan berkuah pekat berwarna kehitaman yang dihasilkan dari sangrahan kemiri, bawang, dan cabai. Rasa gurih, pedas, dan smokey-nya unik beda dari sup ikan daerah lain.',
        'img'   => 'https://cdn.rri.co.id/berita/Palu/t/1719320757171-PEAPI/gute5j68vwgx3mi.jpeg',
        'url'   => '#'
      ],
      [
        'title' => 'Tetu (Lepet Mandar)',
        'desc'  => 'Kue tradisional dari beras ketan yang dimasak bersama santan dan dibungkus daun kelapa muda berbentuk prisma panjang. Biasanya dinikmati saat sarapan atau dijadikan bekal nelayan melaut.',
        'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3FA00YKX1HY3ICxFjNpRGuW5uVUHBZfBL2A&s',
        'url'   => '#'
      ],
      [
        'title' => 'Kopi Mandar',
        'desc'  => 'Kopi robusta khas pegunungan Ulumanda yang disangrai manual hingga menghasilkan aroma kuat dan rasa sedikit pahit namun manis di akhir. Biasanya diseduh dengan gula aren cair.',
        'img'   => 'https://assets.pikiran-rakyat.com/crop/0x0:0x0/1200x675/photo/2024/08/14/4098671562.jpg',
        'url'   => '#'
      ]
    ]
    )

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($kuliner as $k)
        <article class="group rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur
                        shadow-[0_10px_40px_rgba(0,0,0,.35)] overflow-hidden
                        transition transform hover:-translate-y-1">
          <div class="p-4 sm:p-5">
            <div class="aspect-[16/11] w-full overflow-hidden rounded-xl ring-1 ring-white/20">
              <img src="{{ asset($k['img']) }}" alt="{{ $k['title'] }}"
                   class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.02]">
            </div>

            <h3 class="mt-4 text-xl sm:text-2xl font-semibold text-white text-center">
              {{ $k['title'] }}
            </h3>

            <p class="mt-2 text-sm sm:text-base leading-relaxed text-white/80">
              {{ $k['desc'] }}
            </p>

            <div class="mt-4 flex justify-center">
              <a href="{{ $k['url'] }}"
                 class="inline-flex items-center gap-2 rounded-full px-4 py-2
                        bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                        text-white text-sm transition focus:outline-none focus-visible:ring-2
                        focus-visible:ring-white/60">
                <i class="fa-solid fa-compass"></i>
                Learn More
              </a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </section>
@endsection
