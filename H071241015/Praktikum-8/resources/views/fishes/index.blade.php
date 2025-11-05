@extends('layouts.app')

@section('title', 'Daftar Ikan')

@section('content')
    <h1 class="mb-4">Database Ikan Fish It 🐟</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <form action="{{ route('fishes.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari nama ikan..." value="{{ $currentSearch }}">
                            @if($currentRarity)
                                <input type="hidden" name="rarity" value="{{ $currentRarity }}">
                            @endif
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form id="filterRarityForm" action="{{ route('fishes.index') }}" method="GET">
                        @if($currentSearch)
                            <input type="hidden" name="search" value="{{ $currentSearch }}">
                        @endif
                        <select name="rarity" class="form-select" onchange="document.getElementById('filterRarityForm').submit()">
                            <option value="">Semua Rarity</option>
                            @foreach($rarities as $rarity)
                                <option value="{{ $rarity }}" {{ $currentRarity == $rarity ? 'selected' : '' }}>
                                    {{ $rarity }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Ikan</h5>
            <a href="{{ route('fishes.create') }}" class="btn btn-success">Tambah Ikan Baru</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Ikan</th>
                        <th>Rarity</th>
                        <th>Berat (Min-Max)</th>
                        <th>Harga/kg (Coins)</th>
                        <th>Peluang (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fishes as $fish)
                        <tr>
                            <td>{{ $fish->id }}</td>
                            <td><strong>{{ $fish->name }}</strong></td>
                            <td>{{ $fish->rarity }}</td>
                            <td>{{ $fish->base_weight_min }}kg - {{ $fish->base_weight_max }}kg</td>
                            <td>{{ number_format($fish->sell_price_per_kg) }}</td>
                            <td>{{ $fish->catch_probability }}%</td>
                            <td>
                                {{-- Tombol Aksi --}}
                                <a href="{{ route('fishes.show', $fish) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');"> {{-- --}}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data ikan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fishes->total() > 0)
        <div class="card-footer">
            {{ $fishes->links() }}
        </div>
        @endif
    </div>
@endsection