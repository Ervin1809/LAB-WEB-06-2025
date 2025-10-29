@extends('layouts.master')

@section('content')
<section
    class="relative flex items-center py-24 md:py-36"
    style="background-image: url('{{ asset('images/makassar.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"
>
    {{-- Overlay gradient --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/40"></div>

    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white drop-shadow-sm mb-4 leading-none">
            <div class="text-blur-container" id="blur-roll-container">
                <!-- Teks diinput oleh melalui JS -->
            </div>
        </h1>

        <p class="mt-4 text-base md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
            Temukan destinasi menakjubkan, kuliner lezat, dan budaya khas Bugis–Makassar.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="/destinasi"
                class="inline-flex items-center justify-center rounded-full bg-teal-600 px-6 py-3 text-white font-semibold shadow-sm hover:bg-teal-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue-300 transition">
                Jelajahi Destinasi
            </a>
            <a href="/kuliner"
                class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-teal-600 font-semibold shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue-200 transition">
                Cicipi Kuliner
            </a>
        </div>
    </div>
</section>

<!-- Intro Section -->
<section class="py-14 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900" style="font-family: 'LontaraBugis', sans-serif;">
                Aga Kareba !
            </h2>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Makassar, ibu kota Provinsi Sulawesi Selatan, adalah kota pelabuhan yang kaya akan sejarah, budaya, dan keindahan alam.
                Dikenal juga sebagai “Kota Daeng”, Makassar menawarkan pengalaman wisata yang beragam, dari pantai indah hingga kuliner yang menggugah selera.
            </p>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Website ini hadir untuk memandu Anda menjelajahi pesona nusantara di kota Makassar. Temukan tempat-tempat wisata terbaik,
                makanan khas yang lezat, dan momen-momen tak terlupakan bersama kami.
            </p>
        </div>
    </div>
</section>

<!-- Destinasi Populer -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-3xl text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900" style="font-family: 'LontaraBugis', sans-serif;">
                Destinasi Populer
            </h2>
            <p class="mt-2 text-gray-600">
                Rekomendasi pilihan dengan akses mudah dan pemandangan terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pantai Losari -->
            <div
                class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <img src="{{ asset('images/pantai_losari.jpg') }}" alt="Pantai Losari"
                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                <div
                    class="absolute inset-0 bg-black/50 flex flex-col justify-end p-6 text-white opacity-0 group-hover:opacity-100 transition">
                    <h3 class="text-xl font-bold mb-2">Pantai Losari</h3>
                    <p class="text-sm mb-4 line-clamp-2">Pantai ikonik Makassar dengan pemandangan matahari terbenam yang memukau.</p>
                    <a href="/destinasi#pantai-losari"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 hover:bg-blue-700 px-4 py-2 text-sm font-medium transition">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Benteng Rotterdam -->
            <div
                class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <img src="{{ asset('images/benteng_rotterdam.jpg') }}" alt="Benteng Rotterdam"
                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                <div
                    class="absolute inset-0 bg-black/50 flex flex-col justify-end p-6 text-white opacity-0 group-hover:opacity-100 transition">
                    <h3 class="text-xl font-bold mb-2">Benteng Rotterdam</h3>
                    <p class="text-sm mb-4 line-clamp-2">Benteng bersejarah Belanda yang menjadi destinasi wisata budaya.</p>
                    <a href="/destinasi#benteng-rotterdam"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 hover:bg-blue-700 px-4 py-2 text-sm font-medium transition">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Masjid 99 Kubah -->
            <div
                class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <img src="{{ asset('images/masjid_99_kubah.jpg') }}" alt="Masjid 99 Kubah"
                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300" />
                <div
                    class="absolute inset-0 bg-black/50 flex flex-col justify-end p-6 text-white opacity-0 group-hover:opacity-100 transition">
                    <h3 class="text-xl font-bold mb-2">Masjid 99 Kubah</h3>
                    <p class="text-sm mb-4 line-clamp-2">Ikon religi megah di kawasan CPI Makassar dengan arsitektur unik dan menawan.</p>
                    <a href="/destinasi#masjid-99-kubah"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 hover:bg-blue-700 px-4 py-2 text-sm font-medium transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- 🗺️ PETA WISATA MAKASSAR -->
        <div class="mt-16">
            <h3 class="text-5xl font-bold text-center mb-6" style="font-family: 'LontaraBugis', sans-serif;">
                Peta Makassar
            </h3>
            <div id="map" class="rounded-xl shadow-md" style="height: 500px;"></div>
        </div>
    </div>
</section>

<!-- Leaflet JS & CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Peta -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map("map").setView([-5.141620329631013, 119.40642061300163], 15);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap contributors",
        }).addTo(map);

        var locations = [
            { name: "Pantai Losari", coords: [-5.14287687337147, 119.40750280286004] },
            { name: "Benteng Rotterdam", coords: [-5.133983704740371, 119.40547133001293] },
            { name: "Masjid 99 Kubah", coords: [-5.143976806097712, 119.40406962297266] },
        ];

        locations.forEach(function (loc) {
            L.marker(loc.coords)
                .addTo(map)
                .bindPopup("<b>" + loc.name + "</b>");
        });
    });
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
            item.innerHTML = text.split('').map(char => `<span class="char">${char}</span>`).join('');
            return item;
        }

        function animateBlur(item) {
            const chars = item.querySelectorAll('.char');
            let charIndex = 0;
            function revealNextChar() {
                if (charIndex >= chars.length) return;
                chars[charIndex].classList.add('focused');
                charIndex++;
                setTimeout(revealNextChar, 50);
            }
            revealNextChar();
        }

        function showNextText() {
            const activeItem = container.querySelector('.text-blur-item.active');
            if (activeItem) {
                activeItem.classList.remove('active');
                setTimeout(() => activeItem.remove(), 400);
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
@endsection
