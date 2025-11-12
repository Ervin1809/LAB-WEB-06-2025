@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="max-w-6xl mx-auto p-6">
  <div class="bg-[#1e293b] p-6 rounded-2xl shadow-lg border border-[#334155]">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="text-3xl font-semibold text-gray-100 tracking-tight">Daftar Kategori Produk</h2>
        <p class="text-gray-400 text-sm mt-1">Kelola kategori dan lihat produk yang termasuk di dalamnya.</p>
      </div>
      <a href="{{ route('categories.create') }}"
         class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                text-white font-medium rounded-lg shadow transition-all duration-200 transform hover:scale-105">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Kategori
      </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-hidden border border-[#334155] rounded-xl shadow-sm">
      <table class="min-w-full divide-y divide-[#334155]">
        <thead class="bg-[#334155]">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">#</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nama Kategori</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Deskripsi</th>
            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-[#334155] bg-[#1e293b]">
          @forelse ($categories as $cat)
            <tr class="hover:bg-[#24304a] transition duration-150">
              <td class="px-4 py-3 text-sm text-gray-200 font-medium">
                {{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}
              </td>
              <td class="px-4 py-3 text-sm font-semibold text-blue-300">
                {{ $cat->name }}
              </td>
              <td class="px-4 py-3 text-sm text-gray-400">
                {{ Str::limit($cat->description, 60) }}
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center gap-2">

                  <!-- Tombol Lihat -->
                  <a href="{{ route('categories.show', $cat->id) }}"
                    class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white 
                           bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-eye mr-1"></i> Lihat
                  </a>

                  <!-- Tombol Edit -->
                  <a href="{{ route('categories.edit', $cat->id) }}"
                    class="inline-flex items-center justify-center h-8 px-3 text-xs font-medium text-white 
                           bg-yellow-500 hover:bg-yellow-600 rounded-md shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-pen mr-1"></i> Edit
                  </a>

                  <!-- Tombol Hapus -->
                  <form action="{{ route('categories.destroy', $cat->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                Tidak ada kategori yang tersedia.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center text-gray-400">
      {{ $categories->links() }}
    </div>
  </div>
</div>
@endsection
