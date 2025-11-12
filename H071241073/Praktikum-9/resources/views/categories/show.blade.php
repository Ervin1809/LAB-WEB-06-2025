@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="max-w-4xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold text-white mb-4">{{ $category->name }}</h2>

  <p class="text-gray-300 mb-6">
    <span class="font-medium text-gray-400">Deskripsi:</span><br>
    {{ $category->description ?? '-' }}
  </p>

  <div class="text-sm text-gray-400 mb-4">
    <p><span class="font-medium text-gray-300">Dibuat pada:</span> {{ $category->created_at->translatedFormat('d F Y H:i') }}</p>
    <p><span class="font-medium text-gray-300">Terakhir diperbarui:</span> {{ $category->updated_at->translatedFormat('d F Y H:i') }}</p>
  </div>

  <hr class="my-4 border-gray-700">

  <h3 class="text-xl font-semibold text-white mb-3">Produk dalam Kategori Ini</h3>
  @if($category->products->count() > 0)
    <table class="min-w-full border border-gray-700 rounded-lg overflow-hidden">
      <thead class="bg-gray-800 text-gray-300">
        <tr>
          <th class="py-2 px-4 text-left">#</th>
          <th class="py-2 px-4 text-left">Nama Produk</th>
          <th class="py-2 px-4 text-left">Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($category->products as $p)
          <tr class="border-t border-gray-700 hover:bg-gray-800">
            <td class="py-2 px-4">{{ $loop->iteration }}</td>
            <td class="py-2 px-4 text-blue-400 font-medium">
              <a href="{{ route('products.show', $p->id) }}" class="hover:underline">{{ $p->name }}</a>
            </td>
            <td class="py-2 px-4">Rp {{ number_format($p->price, 2, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="text-gray-500">Belum ada produk di kategori ini.</p>
  @endif

  <div class="mt-6 flex gap-3">
    <a href="{{ route('categories.index') }}"
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">Kembali</a>
    <a href="{{ route('categories.edit', $category->id) }}"
       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-white transition">Edit</a>
  </div>
</div>
@endsection
