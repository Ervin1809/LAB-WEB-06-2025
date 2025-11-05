@extends('layouts.app')

@section('title', 'Tambah Ikan Baru - Fish It Roblox')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Ikan Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('fishes.store') }}" method="POST">
                    @csrf

                    <!-- Nama Ikan -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Ikan <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Neon Goldfish">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rarity -->
                    <div class="mb-3">
                        <label for="rarity" class="form-label">Rarity <span class="text-danger">*</span></label>
                        <select class="form-select @error('rarity') is-invalid @enderror" id="rarity" name="rarity">
                            <option value="">Pilih Rarity</option>
                            @foreach($rarities as $rarity)
                                <option value="{{ $rarity }}" {{ old('rarity') == $rarity ? 'selected' : '' }}>
                                    {{ $rarity }}
                                </option>
                            @endforeach
                        </select>
                        @error('rarity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Berat Minimum dan Maksimum -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="base_weight_min" class="form-label">Berat Minimum (kg) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control @error('base_weight_min') is-invalid @enderror" 
                                   id="base_weight_min" 
                                   name="base_weight_min" 
                                   value="{{ old('base_weight_min') }}" 
                                   placeholder="0.50">
                            @error('base_weight_min')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="base_weight_max" class="form-label">Berat Maksimum (kg) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control @error('base_weight_max') is-invalid @enderror" 
                                   id="base_weight_max" 
                                   name="base_weight_max" 
                                   value="{{ old('base_weight_max') }}" 
                                   placeholder="2.50">
                            @error('base_weight_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Harga Jual per KG -->
                    <div class="mb-3">
                        <label for="sell_price_per_kg" class="form-label">Harga Jual per KG (Coins) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-coin text-warning"></i></span>
                            <input type="number" 
                                   class="form-control @error('sell_price_per_kg') is-invalid @enderror" 
                                   id="sell_price_per_kg" 
                                   name="sell_price_per_kg" 
                                   value="{{ old('sell_price_per_kg') }}" 
                                   placeholder="100">
                            @error('sell_price_per_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Peluang Tertangkap -->
                    <div class="mb-3">
                        <label for="catch_probability" class="form-label">Peluang Tertangkap (%) <span class="text-danger">*</span></label>
                        <input type="number" 
                               step="0.01" 
                               class="form-control @error('catch_probability') is-invalid @enderror" 
                               id="catch_probability" 
                               name="catch_probability" 
                               value="{{ old('catch_probability') }}" 
                               placeholder="15.50"
                               min="0.01"
                               max="100">
                        <small class="text-muted">Nilai antara 0.01% - 100%</small>
                        @error('catch_probability')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Deskripsi ikan (opsional)...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Ikan
                        </button>
                        <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection