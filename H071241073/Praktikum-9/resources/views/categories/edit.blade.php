@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold mb-6 text-white">Edit Kategori Produk</h2>

  <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- Nama Kategori -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Nama Kategori</label>
      <input type="text" name="name" id="name"
             class="mt-1 block w-full rounded-lg border border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('name', $category->name) }}" required>
      @error('name')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Deskripsi -->
    <div>
      <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi (opsional)</label>
      <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full rounded-lg border border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                       focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description', $category->description) }}</textarea>
      @error('description')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Tombol -->
    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition">
        Perbarui
      </button>
      <a href="{{ route('categories.index') }}"
         class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
