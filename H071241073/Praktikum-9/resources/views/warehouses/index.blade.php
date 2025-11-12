@extends('layouts.app')

@section('title', 'Daftar Gudang')

@section('content')
<div class="max-w-5xl mx-auto p-6">
  <div class="bg-[#1e293b] p-6 rounded-2xl shadow-lg border border-[#334155]">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="text-3xl font-semibold text-gray-100 tracking-tight">Daftar Gudang</h2>
        <p class="text-gray-400 text-sm mt-1">Kelola data gudang dan lokasi penyimpanan produk.</p>
      </div>
      <a href="{{ route('warehouses.create') }}"
         class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                text-white font-medium rounded-lg shadow transition-all duration-200 transform hover:scale-105">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Gudang
      </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-hidden border border-[#334155] rounded-xl shadow-sm">
      <table class="min-w-full divide-y divide-[#334155]">
        <thead class="bg-[#334155]">
          <tr>
            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">#</th>
            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nama Gudang</th>
            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Lokasi</th>
            <th class="py-3 px-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#334155] bg-[#1e293b]">
          @forelse ($warehouses as $wh)
            <tr class="hover:bg-[#24304a] transition duration-150">
              <td class="py-3 px-4 text-sm text-gray-200 font-medium">
                {{ $loop->iteration + ($warehouses->currentPage()-1)*$warehouses->perPage() }}
              </td>
              <td class="py-3 px-4 text-sm font-semibold text-blue-300">
                <a href="{{ route('warehouses.show', $wh->id) }}" class="hover:underline">{{ $wh->name }}</a>
              </td>
              <td class="py-3 px-4 text-sm text-gray-400">{{ $wh->location ?? '-' }}</td>
              <td class="py-3 px-4 text-center">
                <div class="flex justify-center gap-2">

                  <!-- Tombol Lihat -->
                  <a href="{{ route('warehouses.show', $wh->id) }}"
                     class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white 
                            bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-eye mr-1"></i> Lihat
                  </a>

                  <!-- Tombol Edit -->
                  <a href="{{ route('warehouses.edit', $wh->id) }}"
                     class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white 
                            bg-yellow-500 hover:bg-yellow-600 rounded-md shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-pen mr-1"></i> Edit
                  </a>

                  <!-- Tombol Hapus -->
                  <form action="{{ route('warehouses.destroy', $wh->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus gudang ini?')"
                        class="inline-flex items-center justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white 
                                   bg-red-600 hover:bg-red-700 rounded-md shadow-sm transition-all duration-200">
                      <i class="fa-solid fa-trash mr-1"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-6 text-center text-gray-500 text-sm">
                Belum ada data gudang.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center text-gray-400">
      {{ $warehouses->links() }}
    </div>
  </div>
</div>
@endsection
