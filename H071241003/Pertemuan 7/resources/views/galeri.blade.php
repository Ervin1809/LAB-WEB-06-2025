@extends('template.master')
@section('title','Destinasi')

@section('content')
  {{-- overlay kontras --}}
  <div class="fixed inset-0 bg-black/30 pointer-events-none -z-10"></div>

  <section class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <header class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight">Galeri</h1>
      <p class="text-white/70 mt-2">Berbagai keindahan dan budaya khas Majene</p>
    </header>

    @php(
        $destinations = [
      [
        'title' => 'Sayyang Pattu’du',
        'img'   => 'https://www.gerbangkaltim.com/wp-content/uploads/2020/01/IMG-20191231-WA0046.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Perahu Sandeq',
        'img'   => 'https://awsimages.detik.net.id/community/media/visual/2022/08/31/perahu-sandeq-1_169.jpeg?w=650',
        'url'   => '#'
      ],
      [
        'title' => 'Air Terjun Limbua',
        'img'   => 'https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2023/07/23/dadi-1616541893.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Masjid Agung Ilaikal Masir',
        'img'   => 'https://i.pinimg.com/736x/45/ff/33/45ff33b7ad7a7b3d31d45c57afbe355b.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Pasar Ikan Tradisional Majene',
        'img'   => 'https://cdn1-production-assets-kly.akamaized.net/medias/1199154/big/099161300_1460359330-pasar_ikan.jpg',
        'url'   => '#'
      ],
      [
        'title' => 'Gunung Salabose',
        'img'   => 'https://images.genpi.co/uploads/news/normal/2019/04/21/3ce17a913c1110919805d85af792a808.jpeg',
        'url'   => '#'
      ],
      [
        'title' => 'Makam Raja Khadat',
        'img'   => 'https://asset-2.tribunnews.com/sulbar/foto/bank/images/Kompleks-makam-raja-raja-dan-hadat-Banggae.jpg',
        'url'   => '#'
      ],
    ]
    )

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($destinations as $d)
        <article class="group rounded-none bg-white/10 ring-1 ring-white/20 backdrop-blur
                        shadow-[0_10px_40px_rgba(0,0,0,.35)] overflow-hidden
                        transition transform">
          <div class="p-4 sm:p-5">
            <div class="aspect-[16/11] w-full overflow-hidden rounded-xl ring-1 ring-white/20">
              <img src="{{ asset($d['img']) }}" alt="{{ $d['title'] }}"
                   class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.02]">
            </div>

            <h3 class="mt-4 text-xl sm:text-2xl font-semibold text-white text-center">
              {{ $d['title'] }}
            </h3>

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
