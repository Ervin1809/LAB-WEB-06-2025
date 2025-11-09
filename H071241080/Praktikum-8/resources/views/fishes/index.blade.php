{{-- resources/views/fishes/index.blade.php --}}

@extends('layouts.app') 

@section('title', 'Daftar Ikan Fish It Simulator') 

@section('content')

@push('styles')
<style>
    /* Sortable Header Styling - Spotify Style */
    .sortable-header {
        color: #374151;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.2s ease;
        font-weight: 600;
        cursor: pointer;
        user-select: none;
    }

    .sortable-header:hover {
        color: var(--ocean-blue);
        background: rgba(59, 130, 246, 0.1);
    }

    .sortable-header.active {
        color: var(--ocean-blue);
        font-weight: 700;
    }

    .sortable-header .sort-icon {
        font-size: 0.75rem;
        color: var(--cyan-bright);
        font-weight: bold;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Table hover effect enhancement */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
        transform: scale(1.01);
    }
</style>
@endpush

<div class="card card-ocean shadow mb-4">
    <div class="card-header card-header-ocean d-flex justify-content-between align-items-center">
        <h5>🎣 Database Ikan Fish It</h5>
    </div>

    <div class="card-body">
        
        {{-- Form Filter dan Search --}}
        <form action="{{ route('fishes.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                
                {{-- Filter Rarity --}}
                <div class="col-md-4">
                    <label for="rarity" class="form-label fw-semibold">
                        <span class="text-muted">⭐</span> Filter Rarity:
                    </label>
                    <select name="rarity" id="rarity" class="form-select">
                        <option value="">-- Tampilkan Semua Rarity --</option>
                        @foreach($rarities as $r)
                            <option value="{{ $r }}" {{ request('rarity') == $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Search Nama --}}
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold">
                        <span class="text-muted">🔍</span> Search Nama Ikan:
                    </label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Cari berdasarkan nama...">
                </div>

                {{-- Tombol Filter --}}
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-ocean w-100">
                        Filter
                    </button>
                </div>

                {{-- Tombol Reset --}}
                @if(request('rarity') || request('search'))
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <a href="{{ route('fishes.index') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                @endif
            </div>
        </form>

        {{-- Tabel Data Ikan --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle" width="100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        
                        {{-- Sortable: Nama Ikan --}}
                        <th style="width: 20%">
                            <a href="{{ route('fishes.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'name', 'direction' => (request('sort') == 'name' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                               class="sortable-header {{ request('sort') == 'name' ? 'active' : '' }}">
                                Nama Ikan
                                @if(request('sort') == 'name')
                                    <span class="sort-icon">
                                        @if(request('direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        
                        {{-- Sortable: Rarity --}}
                        <th class="text-center" style="width: 12%">
                            <a href="{{ route('fishes.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'rarity', 'direction' => (request('sort') == 'rarity' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                               class="sortable-header {{ request('sort') == 'rarity' ? 'active' : '' }}">
                                Rarity
                                @if(request('sort') == 'rarity')
                                    <span class="sort-icon">
                                        @if(request('direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        
                        {{-- Sortable: Berat --}}
                        <th class="text-center" style="width: 18%">
                            <a href="{{ route('fishes.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'base_weight_min', 'direction' => (request('sort') == 'base_weight_min' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                               class="sortable-header {{ request('sort') == 'base_weight_min' ? 'active' : '' }}">
                                Berat (Min-Max)
                                @if(request('sort') == 'base_weight_min')
                                    <span class="sort-icon">
                                        @if(request('direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        
                        {{-- Sortable: Harga --}}
                        <th class="text-center" style="width: 13%">
                            <a href="{{ route('fishes.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'sell_price_per_kg', 'direction' => (request('sort') == 'sell_price_per_kg' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                               class="sortable-header {{ request('sort') == 'sell_price_per_kg' ? 'active' : '' }}">
                                Harga/Kg
                                @if(request('sort') == 'sell_price_per_kg')
                                    <span class="sort-icon">
                                        @if(request('direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        
                        {{-- Sortable: Peluang --}}
                        <th class="text-center" style="width: 12%">
                            <a href="{{ route('fishes.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'catch_probability', 'direction' => (request('sort') == 'catch_probability' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                               class="sortable-header {{ request('sort') == 'catch_probability' ? 'active' : '' }}">
                                Peluang
                                @if(request('sort') == 'catch_probability')
                                    <span class="sort-icon">
                                        @if(request('direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        
                        <th class="text-center" style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fishes as $fish)
                    <tr>
                        <td class="text-center fw-semibold text-muted">
                            {{ $fishes->firstItem() + $loop->index }}
                        </td>
                        <td class="fw-semibold">{{ $fish->name }}</td>
                        <td class="text-center">
                            <span class="badge 
                                @if($fish->rarity == 'Secret') badge-secret
                                @elseif($fish->rarity == 'Mythic') badge-mythic
                                @elseif($fish->rarity == 'Legendary') badge-legendary
                                @elseif($fish->rarity == 'Epic') badge-epic
                                @elseif($fish->rarity == 'Rare') badge-rare
                                @elseif($fish->rarity == 'Uncommon') badge-uncommon
                                @else badge-common
                                @endif
                                px-3 py-2">
                                {{ $fish->rarity }}
                            </span>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">
                                {{ number_format($fish->base_weight_min, 2) }} - {{ number_format($fish->base_weight_max, 2) }} kg
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success px-3 py-2">
                                {{ number_format($fish->sell_price_per_kg) }} 🪙
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark px-3 py-2">
                                {{ number_format($fish->catch_probability, 2) }}%
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('fishes.show', $fish->id) }}" 
                                   class="btn btn-info" title="Lihat Detail">
                                    Detail
                                </a>
                                <a href="{{ route('fishes.edit', $fish->id) }}" 
                                   class="btn btn-warning" title="Edit Data">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $fish->id }}')" title="Hapus Data">
                                    Hapus
                                </button>
                            </div>
                            
                            <form id="delete-form-{{ $fish->id }}" 
                                  action="{{ route('fishes.destroy', $fish->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <h5>🐟 Tidak ada data ikan yang ditemukan</h5>
                                <p class="mb-0">Silakan tambah ikan baru atau ubah filter pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $fishes->links() }}
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(fishId) {
        if (confirm('🗑️ Apakah Anda yakin ingin menghapus ikan ini?\n\nAksi ini tidak dapat dibatalkan!')) {
            document.getElementById('delete-form-' + fishId).submit();
        }
    }
</script>
@endpush