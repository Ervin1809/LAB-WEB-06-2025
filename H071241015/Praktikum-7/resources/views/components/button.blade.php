<a href="{{ $link ?? '#' }}" class="inline-block {{ $type ?? 'bg-blue-500 hover:bg-blue-600' }} text-white font-medium py-2 px-4 rounded-lg transition duration-300 {{ $size ?? '' }}">{{ $slot }}</a>
@props([
    'href' => null,
    'type' => 'button',
])

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => 'inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => 'inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300']) }}>
        {{ $slot }}
    </button>
@endif