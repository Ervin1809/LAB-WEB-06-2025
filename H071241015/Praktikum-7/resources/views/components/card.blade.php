<div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 hover:scale-105">
    @if(isset($image))
        <div class="h-48 overflow-hidden">
            <img src="{{ $image }}" class="w-full h-full object-cover" alt="{{ $title ?? 'Card Image' }}">
        </div>
    @endif
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $title ?? 'Card Title' }}</h3>
        <p class="text-gray-600 mb-4">{{ $description ?? 'Card Description' }}</p>
        @if(isset($buttonText) && isset($buttonLink))
            <a href="{{ $buttonLink }}" class="inline-block bg-linear-to-r from-primary to-secondary text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-300">
                {{ $buttonText }}
            </a>
        @endif
    </div>
</div>