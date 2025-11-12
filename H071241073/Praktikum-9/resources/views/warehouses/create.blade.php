@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded-2xl shadow-lg text-gray-100">
  <h2 class="text-2xl font-semibold mb-6 text-blue-400">Tambah Gudang Baru</h2>

  <form action="{{ route('warehouses.store') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Nama Gudang -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Nama Gudang</label>
      <input type="text" name="name" id="name"
             class="mt-1 block w-full rounded-lg border border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
             placeholder="Contoh: Gudang Makassar"
             value="{{ old('name') }}" required>
      @error('name')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Lokasi Gudang -->
    <div>
      <label for="location" class="block text-sm font-medium text-gray-300">Lokasi Gudang (opsional)</label>
      <textarea name="location" id="location" rows="4"
                class="mt-1 block w-full rounded-lg border border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Alamat atau lokasi">{{ old('location') }}</textarea>
      @error('location')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
        Simpan
      </button>
      <a href="{{ route('warehouses.index') }}"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg text-gray-100 transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
