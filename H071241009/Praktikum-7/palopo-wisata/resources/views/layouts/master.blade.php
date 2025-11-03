<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Palopo - @yield('title', 'Beranda')</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header>
        <h1>Eksplor Pariwisata Kota Palopo</h1>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/destinasi">Destinasi</a></li>
                <li><a href="/kuliner">Kuliner</a></li>
                <li><a href="/galeri">Galeri</a></li>
                <li><a href="/kontak">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 - Tugas Praktikum 7 - Pariwisata Palopo</p>
    </footer>

</body>
</html>