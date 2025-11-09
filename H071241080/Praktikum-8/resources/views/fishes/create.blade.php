{{-- resources/views/fishes/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Ikan Baru')

@section('content')
<div class="card card-ocean shadow mb-4">
    <div class="card-header card-header-ocean">
        <h5>➕ Form Tambah Data Ikan Baru</h5>
    </div>
    <div class="card-body">
        
        <form action="{{ route('fishes.store') }}" method="POST">
            @csrf

            <div class="row">
                
                {{-- Nama Ikan --}}
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Nama Ikan <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Contoh: Megalodon" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rarity --}}
                <div class="col-md-6 mb-3">
                    <label for="rarity" class="form-label fw-semibold">
                        Rarity (Kelangkaan) <span class="text-danger">*</span>
                    </label>
                    @php
                        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
                    @endphp
                    
                    <select class="form-select @error('rarity') is-invalid @enderror" 
                            id="rarity" name="rarity" required>
                        <option value="">-- Pilih Rarity --</option>
                        @foreach($rarities as $r)
                            <option value="{{ $r }}" {{ old('rarity') == $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                    @error('rarity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Berat Minimum --}}
                <div class="col-md-3 mb-3">
                    <label for="base_weight_min" class="form-label fw-semibold">
                        Berat Minimum (kg) <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.01" class="form-control @error('base_weight_min') is-invalid @enderror" 
                           id="base_weight_min" name="base_weight_min" value="{{ old('base_weight_min') }}" 
                           placeholder="0.10" required>
                    @error('base_weight_min')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Berat Maksimum --}}
                <div class="col-md-3 mb-3">
                    <label for="base_weight_max" class="form-label fw-semibold">
                        Berat Maksimum (kg) <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.01" class="form-control @error('base_weight_max') is-invalid @enderror" 
                           id="base_weight_max" name="base_weight_max" value="{{ old('base_weight_max') }}" 
                           placeholder="1.50" required>
                    @error('base_weight_max')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Harga Jual per Kg --}}
                <div class="col-md-3 mb-3">
                    <label for="sell_price_per_kg" class="form-label fw-semibold">
                        Harga Jual/Kg (Coins) <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('sell_price_per_kg') is-invalid @enderror" 
                           id="sell_price_per_kg" name="sell_price_per_kg" value="{{ old('sell_price_per_kg') }}" 
                           placeholder="500" required>
                    @error('sell_price_per_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catch Probability --}}
                <div class="col-md-3 mb-3">
                    <label for="catch_probability" class="form-label fw-semibold">
                        Peluang Tertangkap (%) <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.01" class="form-control @error('catch_probability') is-invalid @enderror" 
                           id="catch_probability" name="catch_probability" value="{{ old('catch_probability') }}" 
                           placeholder="50.00" required>
                    @error('catch_probability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Range: 0.01% - 100.00%</small>
                </div>
                
                {{-- Deskripsi --}}
                <div class="col-md-12 mb-4">
                    <label for="description" class="form-label fw-semibold">
                        Deskripsi Ikan <span class="text-muted">(Opsional)</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" 
                              placeholder="Masukkan deskripsi ikan...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            
            {{-- Info Box --}}
            <div class="alert alert-info border-0 mb-4">
                <strong>ℹ️ Catatan:</strong> 
                <ul class="mb-0 mt-2">
                    <li>Pastikan berat maksimum lebih besar dari berat minimum</li>
                    <li>Peluang tertangkap harus antara 0.01% hingga 100.00%</li>
                    <li>Semua field wajib diisi kecuali deskripsi</li>
                </ul>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    💾 Simpan Ikan
                </button>
                <a href="{{ route('fishes.index') }}" class="btn btn-secondary px-4">
                    ← Batal
                </a>
            </div>
        </form>

    </div>
</div>
@endsection