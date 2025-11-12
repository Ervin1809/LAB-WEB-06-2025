@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('content')
<div class="max-w-5xl mx-auto bg-gray-800 p-6 rounded-2xl shadow-lg text-gray-100">
  <h2 class="text-2xl font-semibold text-blue-400 mb-4">{{ $warehouse->name }}</h2>

  <p class="text-gray-300 mb-3">
    <span class="font-medium text-gray-200">Lokasi:</span> {{ $warehouse->location ?? '-' }}
  </p>

  <div class="text-sm text-gray-400 mb-4">
    <p><span class="font-medium text-gray-300">Dibuat pada:</span> {{ $warehouse->created_at->translatedFormat('d F Y H:i') }}</p>
    <p><span class="font-medium text-gray-300">Terakhir diperbarui:</span> {{ $warehouse->updated_at->translatedFormat('d F Y H:i') }}</p>
  </div>

  <h3 class="text-xl font-semibold text-blue-400 mb-3">Produk di Gudang Ini</h3>

  @if($warehouse->products->count() > 0)
    <div class="overflow-x-auto rounded-lg border border-gray-700">
      <table class="min-w-full border-collapse">
        <thead class="bg-gray-700 text-gray-200">
          <tr>
            <th class="py-2 px-4 text-left w-12">#</th>
            <th class="py-2 px-4 text-left">Nama Produk</th>
            <th class="py-2 px-4 text-left">Kategori</th>
            <th class="py-2 px-4 text-left">Harga</th>
            <th class="py-2 px-4 text-left">Stok</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($warehouse->products as $product)
            <tr class="border-t border-gray-700 hover:bg-gray-700/70 transition">
              <td class="py-2 px-4">{{ $loop->iteration }}</td>
              <td class="py-2 px-4 text-blue-400 font-medium">
                <a href="{{ route('products.show', $product->id) }}" class="hover:underline">
                  {{ $product->name }}
                </a>
              </td>
              <td class="py-2 px-4">{{ $product->category?->name ?? '-' }}</td>
              <td class="py-2 px-4">Rp {{ number_format($product->price, 2, ',', '.') }}</td>
              <td class="py-2 px-4">{{ $product->pivot->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <p class="text-gray-400">Belum ada produk di gudang ini.</p>
  @endif

  <div class="mt-6 flex gap-3">
    <a href="{{ route('warehouses.index') }}"
       class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg text-gray-100 transition">
      Kembali
    </a>
    <a href="{{ route('warehouses.edit', $warehouse->id) }}"
       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white transition">
      Edit
    </a>
  </div>
</div>
@endsection
