@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
<div class="max-w-6xl mx-auto bg-gray-900 text-gray-100 p-6 rounded-2xl shadow">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <h2 class="text-2xl font-semibold text-white">Manajemen Stok Produk</h2>
    <a href="{{ route('stocks.transfer') }}"
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
      + Transfer Stok
    </a>
  </div>

  <!-- Filter Gudang -->
  <form method="GET" action="{{ route('stocks.index') }}" class="mb-6 flex flex-wrap items-center gap-3">
    <label for="warehouse_id" class="text-gray-300 font-medium">Pilih Gudang:</label>
    <select name="warehouse_id" id="warehouse_id"
            class="rounded-lg border border-gray-700 bg-gray-800 text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500">
      <option value="">Semua Gudang</option>
      @foreach ($warehouses as $w)
        <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
          {{ $w->name }}
        </option>
      @endforeach
    </select>
    <button type="submit"
            class="px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition">
      Tampilkan
    </button>
  </form>

  @php
    $grouped = $stocks->groupBy('warehouse.name');
  @endphp

  @forelse ($grouped as $warehouseName => $items)
    <div class="mb-8 border border-gray-700 rounded-xl overflow-hidden shadow">
      <div class="bg-gray-800 px-4 py-3 font-semibold text-gray-100 flex justify-between items-center">
        <span>{{ $warehouseName }}</span>
        <span class="text-sm text-gray-400">Total Produk: {{ $items->count() }}</span>
      </div>

      <table class="min-w-full text-sm">
        <thead class="bg-gray-700 text-gray-200">
          <tr>
            <th class="py-2 px-4 text-center w-12">#</th>
            <th class="py-2 px-4 text-center">Nama Produk</th>
            <th class="py-2 px-4 text-center">Jumlah Stok</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
            <tr class="border-t border-gray-800 hover:bg-gray-800">
              <td class="py-2 px-4 text-center">{{ $loop->iteration }}</td>
              <td class="py-2 px-4 font-medium text-blue-400 text-center">{{ $item->product->name }}</td>
              <td class="py-2 px-4 text-center">{{ $item->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @empty
    <p class="text-center text-gray-400 py-6">Belum ada data stok.</p>
  @endforelse

  <div class="mt-4">
    {{ $stocks->links() }}
  </div>
</div>
@endsection
