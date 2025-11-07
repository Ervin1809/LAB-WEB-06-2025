@extends('layouts.app')
@section('title', 'Daftar Ikan')

@section('content')
<div class="card card-custom shadow-sm">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <h5 class="mb-0">🐠 Daftar Ikan</h5>
        <a href="{{ route('fishes.create') }}" class="btn btn-tambah">➕ Tambah Ikan Baru</a>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('fishes.index') }}" class="row g-3 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-custom" placeholder="Cari nama ikan...">
            </div>
            <div class="col-md-3">
                <select name="rarity" class="form-select form-select-custom">
                    <option value="">Semua Rarity</option>
                    @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
                        <option value="{{ $r }}" {{ request('rarity') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort_by" class="form-select form-select-custom">
                    <option value="">Urutkan Berdasarkan</option>
                    <option value="name" {{ request('sort_by')=='name'?'selected':'' }}>Nama</option>
                    <option value="rarity" {{ request('sort_by')=='rarity'?'selected':'' }}>Rarity</option>
                    <option value="price" {{ request('sort_by')=='price'?'selected':'' }}>Harga</option>
                </select>
            </div>
            <div class="col-md-3 d-flex">
                <select name="dir" class="form-select form-select-custom me-2">
                    <option value="asc" {{ request('dir')=='asc'?'selected':'' }}>Naik</option>
                    <option value="desc" {{ request('dir')=='desc'?'selected':'' }}>Turun</option>
                </select>
                <button type="submit" class="btn btn-biru">🔍</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-header-custom">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Rarity</th>
                        <th>Berat (kg)</th>
                        <th>Harga/kg</th>
                        <th>Probabilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fishes as $fish)
                        <tr>
                            <td>{{ $loop->iteration + ($fishes->currentPage()-1) * $fishes->perPage() }}</td>
                            <td>{{ $fish->name }}</td>
                            <td><span class="badge bg-info text-dark">{{ $fish->rarity }}</span></td>
                            <td>{{ $fish->formatted_weight }}</td>
                            <td>{{ $fish->formatted_price }}</td>
                            <td>{{ $fish->formatted_probability }}</td>
                            <td>
                                <a href="{{ route('fishes.show', $fish) }}" class="btn btn-sm btn-biru">Lihat</a>
                                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-sm btn-kuning">Edit</a>
                                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ikan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-pink">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted">Tidak ada data ikan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $fishes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
