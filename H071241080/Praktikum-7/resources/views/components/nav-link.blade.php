{{-- Mendefinisikan parameter dari parent view --}}
@props(['route', 'title'])

{{-- Membuat link --}}
<a href="{{ url($route) }}" {{ $attributes }}>
    {{ $title }}
</a>