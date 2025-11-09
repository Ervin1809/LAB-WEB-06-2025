{{-- resources/views/fishes/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Ikan: ' . $fish->name)

@section('content')
<div class="card card-ocean shadow mb-4">
    <div class="card-header card-header-ocean d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0">🐟 Detail Ikan: <span class="text-warning">{{ $fish->name }}</span></h5>
        
        {{-- Tombol Aksi Cepat --}}
        <div class="mt-2 mt-md-0">
            <a href="{{ route('fishes.edit', $fish->id) }}" class="btn btn-warning btn-sm me-2">
                ✏️ Edit
            </a>
            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $fish->id }}')">
                🗑️ Hapus
            </button>
            
            <form id="delete-form-{{ $fish->id }}" action="{{ route('fishes.destroy', $fish->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    
    <div class="card-body">

        {{-- Header Info Ikan --}}
        <div class="text-center mb-4 pb-4 border-bottom">
            <h3 class="mb-3">{{ $fish->name }}</h3>
            <span class="badge 
                @if($fish->rarity == 'Secret') badge-secret
                @elseif($fish->rarity == 'Mythic') badge-mythic
                @elseif($fish->rarity == 'Legendary') badge-legendary
                @elseif($fish->rarity == 'Epic') badge-epic
                @elseif($fish->rarity == 'Rare') badge-rare
                @elseif($fish->rarity == 'Uncommon') badge-uncommon
                @else badge-common
                @endif
                fs-5 px-4 py-2">
                ⭐ {{ $fish->rarity }}
            </span>
        </div>

        <div class="row">
            {{-- Bagian Kiri: Statistik Utama --}}
            <div class="col-md-6 mb-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">📊 Statistik Ikan</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-6">⚖️ Berat Minimum</dt>
                            <dd class="col-sm-6 text-end">
                                <span class="badge bg-secondary px-3">{{ number_format($fish->base_weight_min, 2) }} kg</span>
                            </dd>

                            <dt class="col-sm-6">⚖️ Berat Maksimum</dt>
                            <dd class="col-sm-6 text-end">
                                <span class="badge bg-secondary px-3">{{ number_format($fish->base_weight_max, 2) }} kg</span>
                            </dd>
                            
                            <dt class="col-sm-6">💰 Harga Jual per Kg</dt>
                            <dd class="col-sm-6 text-end">
                                <span class="badge bg-success px-3">{{ number_format($fish->sell_price_per_kg, 0, ',', '.') }} Coins 🪙</span>
                            </dd>
                            
                            <dt class="col-sm-6">🎣 Peluang Tertangkap</dt>
                            <dd class="col-sm-6 text-end">
                                <span class="badge bg-info text-dark px-3">{{ number_format($fish->catch_probability, 2) }}%</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            {{-- Bagian Kanan: Info Timestamp --}}
            <div class="col-md-6 mb-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">🕒 Informasi Waktu</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">📅 Dibuat Pada</dt>
                            <dd class="col-sm-7 text-end">
                                <small class="text-muted">{{ optional($fish->created_at)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA</small>
                            </dd>

                            <dt class="col-sm-5">🔄 Diupdate Pada</dt>
                            <dd class="col-sm-7 text-end">
                                <small class="text-muted">{{ optional($fish->updated_at)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA</small>
                            </dd>

                            <dt class="col-sm-5">⏱️ Terakhir Update</dt>
                            <dd class="col-sm-7 text-end">
                                <span class="badge bg-primary">{{ optional($fish->updated_at)->setTimezone('Asia/Makassar')->diffForHumans() }}</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            {{-- Deskripsi (Full Width) --}}
            <div class="col-12">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">📝 Deskripsi Ikan</h5>
                        <p class="mb-0 text-muted" style="line-height: 1.8;">
                            {{ $fish->description ?? '— Tidak ada deskripsi yang tersedia untuk ikan ini. —' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="card-footer bg-white border-top">
        <div class="d-flex gap-2 flex-wrap justify-content-end">
            <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                ← Kembali ke Daftar Ikan
            </a>
        </div>
    </div>
</div>

{{-- Info Cards Grid --}}
<div class="row g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Berat Range</h6>
                <h4 class="mb-0 text-primary">
                    {{ number_format($fish->base_weight_max - $fish->base_weight_min, 2) }} kg
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Potensi Pendapatan Max</h6>
                <h4 class="mb-0 text-success">
                    {{ number_format($fish->sell_price_per_kg * $fish->base_weight_max, 0, ',', '.') }} 🪙
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Tingkat Kesulitan</h6>
                <h4 class="mb-0 text-warning">
                    @if($fish->catch_probability >= 50)
                        Mudah 😊
                    @elseif($fish->catch_probability >= 20)
                        Sedang 😐
                    @elseif($fish->catch_probability >= 5)
                        Sulit 😰
                    @else
                        Sangat Sulit 💀
                    @endif
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted mb-2">Kategori Ukuran</h6>
                <h4 class="mb-0 text-info">
                    @if($fish->base_weight_max <= 1)
                        Kecil 🐟
                    @elseif($fish->base_weight_max <= 10)
                        Sedang 🐠
                    @elseif($fish->base_weight_max <= 100)
                        Besar 🦈
                    @else
                        Raksasa 🐋
                    @endif
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(fishId) {
        if (confirm('🗑️ Apakah Anda yakin ingin menghapus ikan "{{ $fish->name }}"?\n\nAksi ini tidak dapat dibatalkan!')) {
            document.getElementById('delete-form-' + fishId).submit();
        }
    }
</script>
@endpush