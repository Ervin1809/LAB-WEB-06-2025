@extends('layouts.app')

@section('title', 'Daftar Ikan')

@section('content')

@php
  $hasFilter = request()->filled('search') || request()->filled('rarity') || request()->filled('sort') || request()->filled('dir');
  $currentSort = request('sort', 'id');
  $currentDir  = request('dir', 'asc');
  $toggleDir   = $currentDir === 'asc' ? 'desc' : 'asc';

  $rarityColors = [
    'Common'    => 'bg-gray-500/40 text-gray-200',
    'Uncommon'  => 'bg-green-500/40 text-green-200',
    'Rare'      => 'bg-blue-500/40 text-blue-200',
    'Epic'      => 'bg-purple-500/40 text-purple-200',
    'Legendary' => 'bg-yellow-500/40 text-yellow-200',
    'Mythic'    => 'bg-red-500/40 text-red-200',
    'Secret'    => 'bg-cyan-500/40 text-cyan-200',
  ];
@endphp

<!-- Header dan Filter -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
  <h1 class="text-2xl font-bold text-white">Daftar Ikan</h1>

  <form method="GET" id="filterForm" class="flex flex-wrap gap-2 items-center">

    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama ikan..."
           class="border border-gray-400 p-2 rounded bg-white text-black" />

    <select name="rarity" class="border border-gray-400 p-2 rounded bg-white text-black">
      <option value="">Semua Rarity</option>
      @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
        <option value="{{ $r }}" {{ request('rarity') == $r ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>

    <select name="sort" class="border border-gray-400 p-2 rounded bg-white text-black"
            onchange="document.getElementById('filterForm').submit()">
      <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID</option>
      <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
      <option value="sell_price_per_kg" {{ request('sort') == 'sell_price_per_kg' ? 'selected' : '' }}>Harga/kg</option>
      <option value="catch_probability" {{ request('sort') == 'catch_probability' ? 'selected' : '' }}>Peluang</option>
    </select>

    <input type="hidden" name="dir" id="sortDir" value="{{ request('dir', 'asc') }}">

    <button type="button"
            onclick="toggleSortDir()"
            class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-600 flex items-center gap-1">
      <span id="dirIcon">{{ request('dir', 'asc') === 'asc' ? '▲' : '▼' }}</span>
    </button>

    <button class="bg-blue-700 text-white px-3 py-2 rounded hover:bg-blue-600">Terapkan</button>

    <a href="{{ $hasFilter ? route('fishes.index') : '#' }}"
       class="px-3 py-2 rounded border text-sm
       {{ $hasFilter ? 'bg-red-600 text-white hover:bg-red-500' : 'bg-gray-600 text-gray-400 pointer-events-none' }}">
       Reset
    </a>

  </form>
</div>

<!-- Tabel -->
<table class="w-full bg-[#1e2a38] text-gray-200 shadow rounded overflow-hidden border border-gray-700">
  <thead class="bg-[#253446] text-gray-100">
    <tr>
      <th class="p-2 text-center">No</th>
      <th class="p-2">
        <a href="{{ route('fishes.index', array_merge(request()->query(), ['sort' => 'name', 'dir' => $currentSort === 'name' ? $toggleDir : 'asc'])) }}"
           class="flex items-center gap-1 hover:text-blue-300">
          Nama
          @if($currentSort === 'name')
            <span class="text-xs">{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
          @endif
        </a>
      </th>
      <th class="p-2">Rarity</th>
      <th class="p-2">Berat (kg)</th>
      <th class="p-2">
        <a href="{{ route('fishes.index', array_merge(request()->query(), ['sort' => 'sell_price_per_kg', 'dir' => $currentSort === 'sell_price_per_kg' ? $toggleDir : 'asc'])) }}"
           class="flex items-center gap-1 hover:text-blue-300">
          Harga/kg
          @if($currentSort === 'sell_price_per_kg')
            <span class="text-xs">{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
          @endif
        </a>
      </th>
      <th class="p-2">
        <a href="{{ route('fishes.index', array_merge(request()->query(), ['sort' => 'catch_probability', 'dir' => $currentSort === 'catch_probability' ? $toggleDir : 'asc'])) }}"
           class="flex items-center gap-1 hover:text-blue-300">
          Peluang
          @if($currentSort === 'catch_probability')
            <span class="text-xs">{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
          @endif
        </a>
      </th>
      <th class="p-2 text-center">Aksi</th>
    </tr>
  </thead>

  <tbody>
    @forelse($fishes as $fish)
      <tr class="border-t border-gray-700 hover:bg-[#2a3b4d]">
        <td class="p-2 text-center">{{ $fishes->firstItem() + $loop->index }}</td>
        <td class="p-2">{{ $fish->name }}</td>

        <!-- rarity badge -->
        <td class="p-2 text-center">
          <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $rarityColors[$fish->rarity] ?? 'bg-gray-600' }}">
            {{ $fish->rarity }}
          </span>
        </td>

        <td class="p-2 text-center">{{ $fish->formatted_weight_range }}</td>
        <td class="p-2">{{ $fish->formatted_price }}</td>
        <td class="p-2">{{ number_format($fish->catch_probability, 2) }}%</td>

        <td class="p-2 text-center">
          <a href="{{ route('fishes.show', $fish->id) }}" class="text-blue-300 hover:underline mr-2">Lihat</a>
          <a href="{{ route('fishes.edit', $fish->id) }}" class="text-yellow-300 hover:underline mr-2">Edit</a>
          <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST"
                class="inline" onsubmit="return confirm('Yakin ingin menghapus ikan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:underline">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="7" class="p-4 text-center text-gray-400">Belum ada data ikan.</td></tr>
    @endforelse
  </tbody>
</table>

<!-- pagination -->
<div class="mt-4">
  {{ $fishes->links() }}
</div>

<script>
function toggleSortDir() {
    const dirInput = document.getElementById('sortDir');
    const icon = document.getElementById('dirIcon');
    dirInput.value = dirInput.value === 'asc' ? 'desc' : 'asc';
    icon.textContent = dirInput.value === 'asc' ? '▲' : '▼';
    document.getElementById('filterForm').submit();
}
</script>

@endsection
