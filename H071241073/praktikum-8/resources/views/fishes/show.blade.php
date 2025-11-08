@extends('layouts.app')

@section('title','Detail Ikan')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-white">{{ $fish->name }}</h2>

<div class="bg-[#1e2a38] p-6 rounded shadow border border-gray-700 text-gray-200">
  <p><strong>Rarity:</strong> {{ $fish->rarity }}</p>
  <p><strong>Berat:</strong> {{ $fish->formatted_weight_range }}</p>
  <p><strong>Harga / kg:</strong> {{ $fish->formatted_price }}</p>
  <p><strong>Peluang tertangkap:</strong> {{ number_format($fish->catch_probability,2) }}%</p>

  @if($fish->description)
    <p class="mt-2"><strong>Deskripsi:</strong><br>{{ $fish->description }}</p>
  @endif

  <p class="mt-4 text-sm text-gray-400">Dibuat: {{ $fish->created_at }} | Terakhir diupdate: {{ $fish->updated_at }}</p>

  <div class="mt-6 flex gap-3">
    <a href="{{ route('fishes.edit', $fish->id) }}" 
       class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded">
       Edit
    </a>

    <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ikan ini?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">
        Hapus
      </button>
    </form>

    <a href="{{ route('fishes.index') }}" 
       class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded">
       Kembali
    </a>
  </div>
</div>
@endsection
