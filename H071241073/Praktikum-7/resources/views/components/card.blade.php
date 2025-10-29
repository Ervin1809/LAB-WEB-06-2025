@props([
    'imgSrc' => '',
    'title' => 'Judul Default',
    'description' => 'Deskripsi default.'
])
<div {{ $attributes->merge(['class' => 'bg-white shadow-lg rounded-xl overflow-hidden group']) }}>
    <img 
        src="{{ asset('images/' . $imgSrc) }}" 
        alt="{{ $title }}" 
        class="w-full h-48 object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" 
    >

    <div class="p-6">
        <h3 class="text-xl font-bold mb-2 text-slate-800">{{ $title }}</h3>
        <p class="text-slate-600 text-sm leading-relaxed">{{ $description }}</p>
    </div>
</div>