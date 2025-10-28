<nav class="fixed top-0 left-0 w-full z-50 bg-white/20 backdrop-blur-md border-b border-white/30">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">

    <!-- Kiri: logo + judul -->
    <a href="/" class="flex items-center gap-3">
      <img src="{{ asset('assets/vektor_sandeq.png') }}" alt="Eksplor Majene" class="w-9 h-9 object-contain">
      <span class="text-white font-semibold text-xl drop-shadow">Eksplor Majene</span>
    </a>

    <!-- Kanan: menu -->
    <ul class="hidden md:flex items-center gap-4 text-sm">
      <li>
        <a href="/"
           class="inline-flex items-center gap-2 rounded-full px-4 py-2
                  bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                  text-white transition focus:outline-none focus-visible:ring-2
                  focus-visible:ring-white/60">
          <i class="fa-solid fa-house"></i> Beranda
        </a>
      </li>
      <li>
        <a href="/destinasi"
           class="inline-flex items-center gap-2 rounded-full px-4 py-2
                  bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                  text-white transition focus:outline-none focus-visible:ring-2
                  focus-visible:ring-white/60">
          <i class="fa-solid fa-location-dot"></i> Destinasi
        </a>
      </li>
      <li>
        <a href="/kuliner"
           class="inline-flex items-center gap-2 rounded-full px-4 py-2
                  bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                  text-white transition focus:outline-none focus-visible:ring-2
                  focus-visible:ring-white/60">
          <i class="fa-solid fa-utensils"></i> Kuliner
        </a>
      </li>
      <li>
        <a href="/galeri"
           class="inline-flex items-center gap-2 rounded-full px-4 py-2
                  bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                  text-white transition focus:outline-none focus-visible:ring-2
                  focus-visible:ring-white/60">
          <i class="fa-solid fa-image"></i> Galeri
        </a>
      </li>
      <li>
        <a href="/kontak"
           class="inline-flex items-center gap-2 rounded-full px-4 py-2
                  bg-white/15 hover:bg-white/25 ring-1 ring-white/25
                  text-white transition focus:outline-none focus-visible:ring-2
                  focus-visible:ring-white/60">
          <i class="fa-solid fa-envelope"></i> Kontak
        </a>
      </li>
    </ul>

    <!-- Tombol menu sederhana untuk mobile -->
    <button class="md:hidden text-white text-2xl" aria-label="Buka menu">☰</button>
  </div>
</nav>
