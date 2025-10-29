<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Toraja Utara - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .gradient-navbar {
            background: linear-gradient(90deg, #fef3c7, #fde68a, #fbbf24);
        }
        .gradient-footer {
            background: linear-gradient(90deg, #1f2937, #374151, #111827);
        }
        nav a {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="gradient-navbar shadow-md sticky top-0 z-50 backdrop-blur-md bg-opacity-90">
        <nav class="container mx-auto max-w-7xl px-4 sm:px-6 py-3 sm:py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

            {{-- LOGO + JUDUL --}}
            <div class="flex flex-col items-center sm:flex-row sm:items-center sm:justify-start space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                @if (file_exists(public_path('images/logo.jpg')))
                    <img src="{{ asset('images/logo.jpg') }}" 
                         alt="Logo Toraja Utara" 
                         class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border border-yellow-400 shadow-sm">
                @else
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-full flex items-center justify-center shadow-sm">
                        <span class="text-white font-bold text-lg sm:text-xl">TU</span>
                    </div>
                @endif

                <div class="flex flex-col items-center sm:items-start text-center sm:text-left">
                    <h1 class="text-lg sm:text-2xl font-bold text-gray-800 leading-tight">Eksplor Toraja Utara</h1>
                    <p class="text-xs sm:text-sm text-gray-700">Tondok Lepongan Bulan Tana Matarik Allo</p>
                </div>
            </div>

            {{-- MENU NAVIGASI --}}
            <ul class="flex flex-wrap justify-center sm:justify-end gap-2 sm:gap-6 text-sm sm:text-base font-medium w-full sm:w-auto">
                <li>
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('home') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('tentang') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('tentang') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Tentang
                    </a>
                </li>
                <li>
                    <a href="{{ route('destinasi') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('destinasi') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Destinasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('kuliner') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('kuliner') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Kuliner
                    </a>
                </li>
                <li>
                    <a href="{{ route('galeri') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('galeri') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Galeri
                    </a>
                </li>
                <li>
                    <a href="{{ route('event') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('event') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Event
                    </a>
                </li>
                <li>
                    <a href="{{ route('kontak') }}"
                       class="px-3 py-2 rounded-lg transition-colors duration-300
                              {{ request()->routeIs('kontak') ? 'bg-yellow-400 text-gray-900 font-semibold shadow-md' : 'text-gray-700 hover:text-gray-900 hover:bg-yellow-200' }}">
                        Kontak
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="grow {{ request()->routeIs('home') ? 'w-full min-h-screen' : 'container mx-auto max-w-7xl p-6 my-8' }}">
        @if (request()->routeIs('home'))
            @yield('content')
        @else
            <div class="bg-white/90 p-12 rounded-2xl shadow-xl backdrop-blur-sm border border-gray-200">
                @yield('content')
            </div>
        @endif
    </main>

    {{-- FOOTER --}}
    <footer class="gradient-footer text-gray-300 py-6">
        <div class="container mx-auto max-w-7xl text-center">
            <p class="text-sm">
                &copy; 2025 <span class="text-yellow-400 font-semibold">Eksplor Toraja Utara</span>. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
