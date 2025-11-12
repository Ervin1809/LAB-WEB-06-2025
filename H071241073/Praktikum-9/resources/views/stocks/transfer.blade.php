@extends('layouts.app')

@section('title', 'Transfer Stok Produk')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <h2 class="text-2xl font-semibold mb-6 text-white">Transfer Stok Produk</h2>

  <form action="{{ route('stocks.processTransfer') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Pilih Gudang -->
    <div>
      <label for="warehouse_id" class="block text-sm font-medium text-gray-300">Gudang</label>
      <select name="warehouse_id" id="warehouse_id"
              class="mt-1 block w-full rounded-lg bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
        <option value="">-- Pilih Gudang --</option>
        @foreach ($warehouses as $w)
          <option value="{{ $w->id }}" {{ old('warehouse_id') == $w->id ? 'selected' : '' }}>
            {{ $w->name }}
          </option>
        @endforeach
      </select>
      @error('warehouse_id')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Pilih Produk -->
    <div>
      <label for="product_id" class="block text-sm font-medium text-gray-300">Produk</label>
      <select name="product_id" id="product_id"
              class="mt-1 block w-full rounded-lg bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
        <option value="">-- Pilih Produk --</option>
        @foreach ($products as $p)
          <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
            {{ $p->name }}
          </option>
        @endforeach
      </select>
      @error('product_id')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Jumlah (+ / -) -->
    <div>
      <label for="quantity" class="block text-sm font-medium text-gray-300">
        Jumlah (gunakan + untuk menambah, - untuk mengurangi)
      </label>
      <input type="number" name="quantity" id="quantity"
             class="mt-1 block w-full rounded-lg bg-gray-800 border-gray-700 text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
             value="{{ old('quantity') }}" placeholder="Contoh: 10 atau -5" required>
      @error('quantity')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center gap-3 pt-3">
      <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
        Proses Transfer
      </button>
      <a href="{{ route('stocks.index') }}"
         class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
        Kembali
      </a>
    </div>
  </form>
</div>
@endsection
