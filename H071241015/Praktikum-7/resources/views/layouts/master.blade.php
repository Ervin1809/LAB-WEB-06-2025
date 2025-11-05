<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Pariwisata Nusantara - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6a11cb',
                        secondary: '#2575fc',
                        accent: '#ff9a9e',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <header class="bg-gradient-to-r from-primary to-secondary text-white">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl md:text-3xl font-bold">Eksplor Pariwisata Nusantara</h1>
                    <p class="text-white/90">Jelajahi keindahan dan kekayaan budaya Indonesia</p>
                </div>
            </div>
        </div>
        
        <nav class="bg-black/20">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center justify-center py-3">
                    <a href="{{ url('/') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('/') ? 'bg-white/20' : '' }}">Home</a>
                    <a href="{{ url('/destinasi') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('destinasi') ? 'bg-white/20' : '' }}">Destinasi</a>
                    <a href="{{ url('/kuliner') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('kuliner') ? 'bg-white/20' : '' }}">Kuliner</a>
                    <a href="{{ url('/galeri') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('galeri') ? 'bg-white/20' : '' }}">Galeri</a>
                    <a href="{{ url('/kontak') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('kontak') ? 'bg-white/20' : '' }}">Kontak</a>
                    <a href="{{ url('/tentang') }}" class="text-white hover:text-accent mx-2 my-1 px-3 py-2 rounded-lg transition duration-300 {{ request()->is('tentang') ? 'bg-white/20' : '' }}">Tentang</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="min-h-[70vh] py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Eksplor Pariwisata Nusantara. Hak Cipta Dilindungi.</p>
            <div class="mt-2 flex justify-center space-x-4">
                <a href="#" class="text-white hover:text-accent"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white hover:text-accent"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white hover:text-accent"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>