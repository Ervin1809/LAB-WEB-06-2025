@extends('layouts.app')

@section('content')
    <h1>Detail Ikan: {{ $fish->name }}</h1>

    <div class="fish-detail">
        <div><strong>ID:</strong> {{ $fish->id }}</div>
        <div><strong>Nama:</strong> {{ $fish->name }}</div>
        <div><strong>Rarity:</strong> {{ $fish->rarity }}</div>
        <div><strong>Berat:</strong> {{ $fish->base_weight_min }} kg - {{ $fish->base_weight_max }} kg</div>
        <div><strong>Harga Jual:</strong> {{ $fish->sell_price_per_kg }} Coins / kg</div>
        <div><strong>Peluang Tangkap:</strong> {{ $fish->catch_probability }}%</div>
        
        <hr style="border-color: #363A40; margin: 1rem 0;">
        
        <div><strong>Deskripsi:</strong></div>
        <div class="fish-detail-desc">
            {{ $fish->description ?? '(Tidak ada deskripsi)' }}
        </div>
        
        <hr style="border-color: #363A40; margin: 1rem 0;">
        
        <div><strong>Dibuat pada:</strong> {{ $fish->created_at }}</div>
        <div><strong>Diperbarui pada:</strong> {{ $fish->updated_at }}</div>
    </div>

    <div class="mt-3">
        <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
        
        <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline" style="margin-left: 10px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>

        <a href="{{ route('fishes.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Kembali ke Daftar</a>
    </div>
@endsection