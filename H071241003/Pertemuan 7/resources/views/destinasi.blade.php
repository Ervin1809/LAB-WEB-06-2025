@extends('template.master')
@section('title','Destinasi')

@section('content')
  {{-- overlay kontras --}}
  <div class="fixed inset-0 bg-black/30 pointer-events-none -z-10"></div>

  <section class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <header class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight">Destinasi Unggulan</h1>
      <p class="text-white/70 mt-2">Tiga spot andalan Majene. Foto bagus, kaki tetap di tanah.</p>
    </header>

    @php(
        $destinations = [
      [
        'title' => 'Tebing Taraujung',
        'desc'  => 'Tebing alami yang menjulang, view laut luas, favorit pecinta fotografi dan petualangan ringan.',
        'img'   => 'assets/taraujung.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Pantai Dato’',
        'desc'  => 'Hamparan pasir putih dan air sebening kaca. Tebing kapur menambah dramanya, terutama saat sunset.',
        'img'   => 'assets/dato.webp',
        'url'   => '#'
      ],
      [
        'title' => 'Rewata’a Mangrove',
        'desc'  => 'Hutan bakau bertitian kayu. Tenang, teduh, dan cocok untuk belajar ekosistem pesisir.',
        'img'   => 'assets/rewataa.jpeg',
        'url'   => '#'
      ]
    ]
    )

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($destinations as $d)
        <article class="group rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur
                        shadow-[0_10px_40px_rgba(0,0,0,.35)] overflow-hidden
                        transition transform hover:-translate-y-1">
          <div class="p-4 sm:p-5">
            <div class="aspect-[16/11] w-full overflow-hidden rounded-xl ring-1 ring-white/20">
              <img src="{{ asset($d['img']) }}" alt="{{ $d['title'] }}"
                   class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.02]">
            </div>

            <h3 class="mt-4 text-xl sm:text-2xl font-semibold text-white text-center">
              {{ $d['title'] }}
            </h3>

            <p class="mt-2 text-sm sm:text-base leading-relaxed text-white/80">
              {{ $d['desc'] }}
            </p>

            <div class="mt-4 flex justify-center">
              <a href="{{ $d['url'] }}"
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
