@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold mb-6 text-white">Edit Produk</h2>

  <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- Nama Produk -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Nama Produk</label>
      <input type="text" name="name" id="name"
             class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('name', $product->name) }}" required>
    </div>

    <!-- Harga -->
    <div>
      <label for="price" class="block text-sm font-medium text-gray-300">Harga (Rp)</label>
      <input type="number" step="0.01" name="price" id="price"
             class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('price', $product->price) }}" required>
    </div>

    <!-- Kategori -->
    <div>
      <label for="category_id" class="block text-sm font-medium text-gray-300">Kategori</label>
      <select name="category_id" id="category_id"
              class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                     focus:ring-2 focus:ring-green-500 focus:border-green-500">
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>
    </div>

    <hr class="my-4 border-gray-700">

    <!-- Detail Produk -->
    <div>
      <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi Produk</label>
      <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                       focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description', $product->detail->description ?? '') }}</textarea>
    </div>

    <div>
      <label for="weight" class="block text-sm font-medium text-gray-300">Berat (kg)</label>
      <input type="number" step="0.01" name="weight" id="weight"
             class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('weight', $product->detail->weight ?? '') }}">
    </div>

    <div>
      <label for="size" class="block text-sm font-medium text-gray-300">Ukuran</label>
      <input type="text" name="size" id="size"
             class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('size', $product->detail->size ?? '') }}">
    </div>

    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition">
        Perbarui
      </button>
      <a href="{{ route('products.index') }}"
         class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
