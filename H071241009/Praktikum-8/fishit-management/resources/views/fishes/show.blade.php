@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detail Ikan: {{ $fish->name }}</h2>
        <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="card-title">{{ $fish->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $fish->rarity }}</h6>
                    <p class="card-text">{{ $fish->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
                <div class="col-md-4 bg-light p-3 rounded">
                    <h6 class="text-uppercase">Detail:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Harga/kg:</strong> {{ $fish->sell_price_per_kg }} Coins</li>
                        <li><strong>Peluang Tangkap:</strong> {{ $fish->catch_probability }}%</li>
                        <li><strong>Berat:</strong> {{ $fish->base_weight_min }} kg - {{ $fish->base_weight_max }} kg</li>
                        <li><strong>Ditambahkan:</strong> {{ $fish->created_at->format('d M Y, H:i') }}</li>
                        <li><strong>Diupdate:</strong> {{ $fish->updated_at->format('d M Y, H:i') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning me-2">Edit</a>
            <form action="{{ route('fishes.destroy', $fish) }}" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
@endsection