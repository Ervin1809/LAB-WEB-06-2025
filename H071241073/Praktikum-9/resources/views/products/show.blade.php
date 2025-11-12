@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold text-white mb-4">{{ $product->name }}</h2>

  <div class="space-y-2 text-gray-300">
    <p><span class="font-medium text-gray-200">Kategori:</span> {{ $product->category?->name ?? '-' }}</p>
    <p><span class="font-medium text-gray-200">Harga:</span> Rp {{ number_format($product->price, 2, ',', '.') }}</p>
    <p><span class="font-medium text-gray-200">Berat:</span> {{ $product->detail->weight ?? '-' }} kg</p>
    <p><span class="font-medium text-gray-200">Ukuran:</span> {{ $product->detail->size ?? '-' }}</p>
  </div>

  <div class="mt-6">
    <p class="font-medium text-gray-300 mb-2">Deskripsi Produk:</p>
    <p class="text-gray-400 whitespace-pre-line">
      {{ $product->detail->description ?? 'Tidak ada deskripsi.' }}
    </p>
  </div>

  <hr class="my-6 border-gray-700">

  <div class="text-sm text-gray-500">
    <p><span class="font-medium text-gray-300">Dibuat pada:</span> {{ $product->created_at->translatedFormat('d F Y H:i') }}</p>
    <p><span class="font-medium text-gray-300">Terakhir diperbarui:</span> {{ $product->updated_at->translatedFormat('d F Y H:i') }}</p>
  </div>

  <div class="mt-6 flex gap-3">
    <a href="{{ route('products.index') }}"
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
       Kembali
    </a>
    <a href="{{ route('products.edit', $product->id) }}"
       class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white transition">
       Edit
    </a>
  </div>
</div>
@endsection
