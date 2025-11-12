@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold mb-6 text-white">Tambah Kategori Produk</h2>

  <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Nama Kategori -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Nama Kategori</label>
      <input type="text" name="name" id="name"
             class="mt-1 block w-full rounded-lg border border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
             placeholder="Contoh: Elektronik"
             value="{{ old('name') }}" required>
      @error('name')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Deskripsi -->
    <div>
      <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi (opsional)</label>
      <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full rounded-lg border border-gray-700 bg-gray-800 text-gray-100 shadow-sm 
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Deskripsi kategori">{{ old('description') }}</textarea>
      @error('description')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Tombol -->
    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
        Simpan
      </button>
      <a href="{{ route('categories.index') }}"
         class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
