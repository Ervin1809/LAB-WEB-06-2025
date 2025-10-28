@props(['title', 'description', 'image' => 'https://placehold.co/400x200?text=Gambar+Tidak+Tersedia', 'link' => '#', 'linkText' => 'Lihat Detail'])

<div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ $description }}</p>
        <a href="{{ $link }}" class="inline-block bg-blue-500 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
            {{ $linkText }}
        </a>
    </div>
</div>