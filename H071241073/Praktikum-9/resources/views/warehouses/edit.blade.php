@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded-2xl shadow-lg text-gray-100">
  <h2 class="text-2xl font-semibold mb-6 text-blue-400">Edit Gudang</h2>

  <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- Nama Gudang -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Nama Gudang</label>
      <input type="text" name="name" id="name"
             class="mt-1 block w-full rounded-lg border border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
             value="{{ old('name', $warehouse->name) }}" required>
      @error('name')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Lokasi Gudang -->
    <div>
      <label for="location" class="block text-sm font-medium text-gray-300">Lokasi Gudang (opsional)</label>
      <textarea name="location" id="location" rows="4"
                class="mt-1 block w-full rounded-lg border border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('location', $warehouse->location) }}</textarea>
      @error('location')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition">
        Perbarui
      </button>
      <a href="{{ route('warehouses.index') }}"
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg text-gray-100 transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
