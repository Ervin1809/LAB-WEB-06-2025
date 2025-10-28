<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautiful Makassar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-section {
            background-image: url('https://source.unsplash.com/1600x900/?city,skyscraper,indonesia');
            background-size: cover;
            background-position: center;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .header-default {
            background-color: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            transition: background-color 0.3s ease, backdrop-filter 0.3s ease, box-shadow 0.3s ease;
        }

        .header-scrolled {
            background-color: #ffffff; 
            backdrop-filter: none; 
            -webkit-backdrop-filter: none; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); 
        }

        @font-face {
        font-family: 'LontaraBugis';
        src: url('/fonts/Lontara.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        }

    
        .text-blur-container {
            height: 3.5rem;
            md:height: 5rem;
            overflow: hidden;
            position: relative;
        }

        .text-blur-item {
            display: block;
            color: white;
            font-size: 2.5rem;
            md:font-size: 4rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity 0.4s ease, transform 0.4s ease;
            white-space: pre;
        }

        .text-blur-item.active {
            opacity: 1;
            transform: translateY(0);
        }

        .text-blur-item .char {
            display: inline-block;
            filter: blur(2px);
            opacity: 0.3;
            transition: filter 0.1s ease, opacity 0.1s ease;
        }

        .text-blur-item .char.focused {
            filter: blur(0);
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header id="mainHeader" class="header-default shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/logo(2).png') }}" alt="Logo Beutiful Makassar" class="h-20">
                </a>
            </div>

            <!-- Navbar -->
            <nav class="w-full md:w-auto">
                <ul class="flex flex-wrap justify-center space-x-1 md:space-x-6 text-base md:text-lg" style="font-family: 'LontaraBugis', sans-serif;">
                    <li><x-nav-button link="/" text="Home" /></li>
                    <li><x-nav-button link="/destinasi" text="Destinasi" /></li>
                    <li><x-nav-button link="/kuliner" text="Kuliner" /></li>
                    <li><x-nav-button link="/galeri" text="Galeri" /></li>
                    <li><x-nav-button link="/kontak" text="Kontak" /></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Beutiful Makassar. All rights reserved.</p>
                <p class="mt-2 text-gray-400 text-sm">All Right Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Ambil elemen header
        const header = document.getElementById('mainHeader');

        // Fungsi untuk menangani scroll
        function handleScroll() {
            if (window.scrollY > 10) {
                header.classList.add('header-scrolled');
                header.classList.remove('header-default');
            } else {
                header.classList.remove('header-scrolled');
                header.classList.add('header-default');
            }
        }

        // Tambahkan event listener untuk scroll
        window.addEventListener('scroll', handleScroll);

        // Panggil handleScroll sekali saat halaman dimuat untuk memastikan keadaan awal benar
        window.addEventListener('load', handleScroll);
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('blur-roll-container');
        const texts = [
            'Jelajahi Keindahan Makassar',
            'Temukan Pantai Losari & Matahari Terbenam',
            'Rasakan Kuliner Khas Bugis-Makassar',
            'Jelajahi Benteng Rotterdam Bersejarah',
            'Saksikan Kemegahan Masjid 99 Kubah'
        ];

        let currentIndex = 0;

        function createTextElement(text) {
            const item = document.createElement('div');
            item.className = 'text-blur-item';
            // Memecah teks menjadi span per karakter, termasuk spasi
            item.innerHTML = text.split('').map(char => `<span class="char">${char}</span>`).join('');
            return item;
        }

        function animateBlur(item) {
            const chars = item.querySelectorAll('.char');
            let charIndex = 0;

            function revealNextChar() {
                if (charIndex >= chars.length) {
                    return;
                }

                chars[charIndex].classList.add('focused');
                charIndex++;

                setTimeout(revealNextChar, 50); // Delay 50ms per karakter
            }

            revealNextChar();
        }

        function showNextText() {
            // Hapus teks aktif lama
            const activeItem = container.querySelector('.text-blur-item.active');
            if (activeItem) {
                activeItem.classList.remove('active');
                // Tunggu transisi selesai sebelum menghapus elemen
                setTimeout(() => {
                    activeItem.remove();
                }, 400);
            }

            const newItem = createTextElement(texts[currentIndex]);
            container.appendChild(newItem);

            setTimeout(() => {
                newItem.classList.add('active');
                animateBlur(newItem);
            }, 100);
            currentIndex = (currentIndex + 1) % texts.length;
            setTimeout(showNextText, 5000);
        }

        showNextText();
    });
    </script>

</body>
</html>
