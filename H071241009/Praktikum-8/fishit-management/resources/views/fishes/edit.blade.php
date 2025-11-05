@extends('layouts.app')

@section('content')
    <h2>Edit Data Ikan: {{ $fish->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fishes.update', $fish) }}" method="POST">
        @csrf
        @method('PUT') <div class="card p-3">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Ikan</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $fish->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="rarity" class="form-label">Rarity</label>
                <select name="rarity" id="rarity" class="form-select" required>
                    <option value="">Pilih Rarity</option>
                    <option value="Common" {{ old('rarity', $fish->rarity) == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ old('rarity', $fish->rarity) == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ old('rarity', $fish->rarity) == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Epic" {{ old('rarity', $fish->rarity) == 'Epic' ? 'selected' : '' }}>Epic</option>
                    <option value="Legendary" {{ old('rarity', $fish->rarity) == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                    <option value="Mythic" {{ old('rarity', $fish->rarity) == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                    <option value="Secret" {{ old('rarity', $fish->rarity) == 'Secret' ? 'selected' : '' }}>Secret</option>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="base_weight_min" class="form-label">Berat Minimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_min" class="form-control" id="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="base_weight_max" class="form-label">Berat Maksimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_max" class="form-control" id="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sell_price_per_kg" class="form-label">Harga Jual / kg (Coins)</label>
                    <input type="number" name="sell_price_per_kg" class="form-control" id="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="catch_probability" class="form-label">Peluang Tertangkap (%)</label>
                    <input type="number" step="0.01" name="catch_probability" class="form-control" id="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $fish->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('fishes.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
@endsection