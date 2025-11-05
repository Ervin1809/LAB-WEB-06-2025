@props(['image', 'title'])

<div {{ $attributes->merge(['class' => 'card']) }}>
    <img src="{{ asset($image ?? 'images/placeholder.jpg') }}" alt="{{ $title }}">
    <div class="card-content">
        <h3>{{ $title }}</h3>
        <p>{{ $slot }}</p>
    </div>
</div>