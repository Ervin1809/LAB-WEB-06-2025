@extends('layouts.app')

@section('title', 'Daftar Ikan - Fish It Roblox')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="display-5"><i class="bi bi-database"></i> Fish Database</h1>
        <p class="text-muted">Kelola data ikan untuk game Fish It Roblox</p>
    </div>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('fishes.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><i class="bi bi-search"></i> Cari Nama Ikan</label>
                <input type="text" name="search" class="form-control" placeholder="Masukkan nama ikan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="bi bi-star"></i> Filter Rarity</label>
                <select name="rarity" class="form-select">
                    <option value="">Semua Rarity</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="bi bi-sort-down"></i> Urutkan</label>
                <select name="sort" class="form-select">
                    <option value="">Default (Terbaru)</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                    <option value="sell_price_per_kg" {{ request('sort') == 'sell_price_per_kg' ? 'selected' : '' }}>Harga</option>
                    <option value="catch_probability" {{ request('sort') == 'catch_probability' ? 'selected' : '' }}>Probabilitas</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </form>
        @if(request()->hasAny(['search', 'rarity', 'sort']))
            <div class="mt-3">
                <a href="{{ route('fishes.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Reset Filter
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Tabel Ikan -->
<div class="card shadow-sm">
    <div class="card-body">
        @if($fishes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Rarity</th>
                            <th>Berat (kg)</th>
                            <th>Harga/kg</th>
                            <th>Catch %</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fishes as $fish)
                            <tr>
                                <td>{{ $fish->id }}</td>
                                <td><strong>{{ $fish->name }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $fish->rarity_color }}">
                                        {{ $fish->rarity }}
                                    </span>
                                </td>
                                <td>{{ $fish->weight_range }}</td>
                                <td>
                                    <i class="bi bi-coin text-warning"></i> {{ $fish->formatted_price }}
                                </td>
                                <td>{{ $fish->catch_probability }}%</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $fish->id }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $fish->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin menghapus ikan <strong>{{ $fish->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $fishes->firstItem() }} - {{ $fishes->lastItem() }} dari {{ $fishes->total() }} ikan
                </div>
                <div>
                    {{ $fishes->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="mt-3">Tidak ada ikan ditemukan</h4>
                <p class="text-muted">Tambahkan ikan baru atau ubah filter pencarian</p>
                <a href="{{ route('fishes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Ikan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection