@extends('layouts.app')

@section('title', $fish->name . ' - Fish It Roblox')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm fish-card">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="bi bi-water"></i> {{ $fish->name }}
                    </h3>
                    <span class="badge bg-{{ $fish->rarity_color }} fs-5">
                        {{ $fish->rarity }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Informasi Utama -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <i class="bi bi-info-circle"></i> Informasi Dasar
                                </h5>
                                <hr>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>ID:</strong></td>
                                        <td>{{ $fish->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama:</strong></td>
                                        <td>{{ $fish->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rarity:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $fish->rarity_color }}">
                                                {{ $fish->rarity }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $fish->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Update Terakhir:</strong></td>
                                        <td>{{ $fish->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Ikan -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-success">
                                    <i class="bi bi-bar-chart"></i> Statistik
                                </h5>
                                <hr>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong><i class="bi bi-arrow-down-up"></i> Berat:</strong></td>
                                        <td>{{ $fish->weight_range }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-coin text-warning"></i> Harga/kg:</strong></td>
                                        <td>{{ $fish->formatted_price }} Coins</td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-percent"></i> Catch Rate:</strong></td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-success" 
                                                     role="progressbar" 
                                                     style="width: {{ min($fish->catch_probability, 100) }}%">
                                                    {{ $fish->catch_probability }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Estimasi Nilai -->
                                <div class="alert alert-success mt-3 mb-0">
                                    <strong><i class="bi bi-cash-coin"></i> Estimasi Nilai:</strong><br>
                                    Min: <strong>{{ number_format($fish->base_weight_min * $fish->sell_price_per_kg, 0, ',', '.') }}</strong> Coins<br>
                                    Max: <strong>{{ number_format($fish->base_weight_max * $fish->sell_price_per_kg, 0, ',', '.') }}</strong> Coins
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    @if($fish->description)
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-secondary">
                                    <i class="bi bi-file-text"></i> Deskripsi
                                </h5>
                                <hr>
                                <p class="mb-0">{{ $fish->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Ikan
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i> Hapus Ikan
                    </button>
                    <a href="{{ route('fishes.index') }}" class="btn btn-secondary ms-auto">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus ikan <strong>{{ $fish->name }}</strong>?</p>
                <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection