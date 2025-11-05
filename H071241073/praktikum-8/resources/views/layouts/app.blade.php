<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Fish It - @yield('title')</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tailwind Custom Config (rarity colors + dark theme) -->
  <script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          rarity: {
            common: '#9ca3af',        //abu
            uncommon: '#10b981',      // hijau
            rare: '#3b82f6',          // biru
            epic: '#8b5cf6',          // ungu
            legendary: '#fbbf24',     // emas
            mythic: '#f472b6',        // pink/magenta
            secret: '#f87171',        // merah muda/merah terang
          }
        }
      }
    }
  }
  </script>


  <style>
    /* Glass dark effect */
    .glass {
      backdrop-filter: blur(10px);
      background: rgba(15, 23, 42, 0.6);
    }

    /* Rarity Badge */
    .rarity-badge {
      @apply text-xs font-semibold px-2 py-1 rounded-full uppercase tracking-wide;
    }
    .rarity-common     { background: color-mix(in srgb, theme(colors.rarity.common) 20%, black);     color: theme(colors.rarity.common); }
    .rarity-uncommon   { background: color-mix(in srgb, theme(colors.rarity.uncommon) 20%, black);   color: theme(colors.rarity.uncommon); }
    .rarity-rare       { background: color-mix(in srgb, theme(colors.rarity.rare) 20%, black);       color: theme(colors.rarity.rare); }
    .rarity-epic       { background: color-mix(in srgb, theme(colors.rarity.epic) 20%, black);       color: theme(colors.rarity.epic); }
    .rarity-legendary  { background: color-mix(in srgb, theme(colors.rarity.legendary) 20%, black);  color: theme(colors.rarity.legendary); }
    .rarity-mythic   { background: color-mix(in srgb, theme(colors.rarity.mythic) 20%, black);   color: theme(colors.rarity.mythic); }
    .rarity-secret   { background: color-mix(in srgb, theme(colors.rarity.secret) 20%, black);   color: theme(colors.rarity.secret); }
  </style>

</head>

<body class="min-h-screen text-gray-200 bg-gradient-to-b from-[#0d1b2a] to-[#000814]">

  <!-- NAVBAR -->
  <nav class="glass shadow-lg border-b border-gray-700">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">

      <!-- LOGO + TITLE -->
      <a href="{{ route('fishes.index') }}" class="text-xl flex items-center gap-3 font-bold hover:opacity-80 transition">
        <img src="{{ asset('images/logo.jpg') }}"
             alt="Logo"
             class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 shadow-md">

        <span class="text-blue-300">Fish It Simulator</span>
      </a>

      <div>
        @if(Route::is('fishes.index'))
          <a href="{{ route('fishes.create') }}"
            class="inline-block bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
            + Tambah Ikan
          </a>
        @else
          <a href="{{ route('fishes.index') }}"
            class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
            Kembali
          </a>
        @endif
      </div>
    </div>
  </nav>

  <!-- FLASH MESSAGE -->
  <main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
      <div class="bg-green-900/30 border border-green-600 text-green-300 p-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

</body>
</html>