@extends('layouts.app')

@section('title', 'Detail Ikan')

@section('content')
<div class="card shadow-sm border-0" style="background-color: #f0f8ff;">
    <div class="card-header text-white" style="background-color: #4a90e2;">
        <h5 class="mb-0">🐟 Detail Ikan: {{ $fish->name }}</h5>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <strong>Nama Ikan:</strong> {{ $fish->name }}
        </div>

        <div class="mb-3">
            <strong>Rarity:</strong> {{ $fish->rarity ? 'Rarity ' . $fish->rarity : '-' }}
        </div>

        <div class="mb-3">
            <strong>Berat Minimum:</strong>
            @if($fish->base_weight_min && $fish->base_weight_min > 0)
                {{ number_format($fish->base_weight_min, 2) }} kg
            @else
                -
            @endif
        </div>

        <div class="mb-3">
            <strong>Berat Maksimum:</strong>
            @if($fish->base_weight_max && $fish->base_weight_max > 0)
                {{ number_format($fish->base_weight_max, 2) }} kg
            @else
                -
            @endif
        </div>

        <div class="mb-3">
            <strong>Harga per Kg:</strong>
            @if($fish->sell_price_per_kg && $fish->sell_price_per_kg > 0)
                {{ number_format($fish->sell_price_per_kg, 0, ',', '.') }} Coins
            @else
                -
            @endif
        </div>

        <div class="mb-3">
            <strong>Peluang Tertangkap:</strong>
            @if($fish->catch_probability && $fish->catch_probability > 0)
                {{ number_format($fish->catch_probability, 2) }}%
            @else
                -
            @endif
        </div>

        <div class="mb-3">
            <strong>Deskripsi:</strong>
            <p class="mt-1">{{ $fish->description ?: '-' }}</p>
        </div>

        <div class="mb-3">
            <strong>Waktu Dibuat:</strong> {{ $fish->created_at->format('d M Y, H:i') }}
        </div>

        <div class="mb-3">
            <strong>Terakhir Diperbarui:</strong> {{ $fish->updated_at->format('d M Y, H:i') }}
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali</a>
            
            <div class="d-flex gap-2">
                
                {{-- Tambah parameter from=show --}}
                <a href="{{ route('fishes.edit', $fish) }}?from=show" class="btn btn-warning text-white">Edit</a>

                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ikan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
