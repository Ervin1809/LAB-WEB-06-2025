<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Manajemen Produk')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* === Tema Gelap Elegan === */
    body {
      background-color: #0f172a; /* biru gelap elegan */
      color: #e2e8f0;
      font-family: 'Inter', sans-serif;
    }

    /* Header / Navbar */
    nav {
      background-color: #1e293b; /* abu kebiruan gelap */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
    }

    nav a {
      color: #f1f5f9;
      transition: color 0.2s ease-in-out;
    }

    nav a:hover {
      color: #93c5fd; /* biru lembut saat hover */
    }

    nav .underline {
      text-decoration: underline;
      text-underline-offset: 4px;
      text-decoration-color: #3b82f6;
    }

    /* Konten */
    main {
      background-color: transparent;
    }

    /* Pesan sukses & error */
    .bg-green-100 {
      background-color: rgba(34, 197, 94, 0.15) !important;
      border-color: rgba(34, 197, 94, 0.4) !important;
      color: #bbf7d0 !important;
    }

    .bg-red-100 {
      background-color: rgba(239, 68, 68, 0.15) !important;
      border-color: rgba(239, 68, 68, 0.4) !important;
      color: #fecaca !important;
    }

    /* Komponen umum */
    .bg-white {
      background-color: #1e293b !important;
      color: #f8fafc !important;
      border: 1px solid #334155;
    }

    table {
      border-color: #334155;
      background-color: #1e293b;
    }

    th {
      background-color: #334155;
      color: #f1f5f9;
    }

    td {
      color: #e2e8f0;
    }

    /* Tombol */
    .bg-blue-600, .bg-blue-500 {
      background-color: #2563eb !important;
    }
    .bg-blue-600:hover, .bg-blue-500:hover {
      background-color: #1d4ed8 !important;
    }

    .bg-yellow-400 {
      background-color: #eab308 !important;
    }
    .bg-yellow-400:hover {
      background-color: #ca8a04 !important;
    }

    .bg-red-500 {
      background-color: #dc2626 !important;
    }
    .bg-red-500:hover {
      background-color: #b91c1c !important;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      background-color: #1e293b;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #475569;
      border-radius: 4px;
    }
  </style>
</head>

<body class="min-h-screen text-gray-100">

  <!-- Header / Navbar -->
  <nav>
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Judul di kiri -->
      <a href="{{ route('products.index') }}" class="text-lg font-semibold tracking-wide hover:text-blue-400 transition">
        🛍️ Manajemen Produk
      </a>

      <!-- Nav Links di kanan -->
      <div class="flex items-center gap-6 text-sm font-medium">
        <a href="{{ route('categories.index') }}" 
           class="hover:text-blue-400 {{ request()->is('categories*') ? 'underline' : '' }}">
          Kategori
        </a>
        <a href="{{ route('warehouses.index') }}" 
           class="hover:text-blue-400 {{ request()->is('warehouses*') ? 'underline' : '' }}">
          Gudang
        </a>
        <a href="{{ route('products.index') }}" 
           class="hover:text-blue-400 {{ request()->is('products*') ? 'underline' : '' }}">
          Produk
        </a>
        <a href="{{ route('stocks.index') }}" 
           class="hover:text-blue-400 {{ request()->is('stocks*') ? 'underline' : '' }}">
          Stok
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="py-8 px-4">
    @if(session('success'))
      <div class="max-w-3xl mx-auto mb-4 bg-green-100 border text-green-300 px-4 py-2 rounded-lg shadow">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="max-w-3xl mx-auto mb-4 bg-red-100 border text-red-300 px-4 py-2 rounded-lg shadow">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>

</body>
</html>
