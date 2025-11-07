@extends('layouts.app')
@section('title', 'Edit Ikan')

@section('content')
<div class="card card-custom shadow-sm">
    <div class="card-header-custom">
        <h5 class="mb-0">✏️ Edit Data Ikan</h5>
    </div>

    <div class="card-body">

        {{-- FORM --}}
        <form action="{{ route('fishes.update', $fish) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Tambahan untuk menentukan redirect tujuan setelah update --}}
            <input type="hidden" name="redirect_to" value="{{ request('from') }}">

            <div class="mb-3">
                <label class="form-label">Nama Ikan</label>
                <input type="text" name="name" value="{{ old('name', $fish->name) }}" class="form-control form-control-custom">
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rarity</label>
                <select name="rarity" class="form-select form-select-custom">
                    <option value="">-- Pilih Rarity --</option>
                    @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
                        <option value="{{ $r }}" {{ old('rarity', $fish->rarity) == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
                @error('rarity') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Berat Minimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}" class="form-control form-control-custom">
                    @error('base_weight_min') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Berat Maksimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}" class="form-control form-control-custom">
                    @error('base_weight_max') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga per Kg</label>
                <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" class="form-control form-control-custom">
                @error('sell_price_per_kg') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Probabilitas Tangkap (%)</label>
                <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}" class="form-control form-control-custom">
                @error('catch_probability') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control form-control-custom" rows="3">{{ old('description', $fish->description) }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-biru">Perbarui Data</button>

                {{-- Cancel otomatis kembali ke index atau show --}}
                <a href="{{ request('from') === 'show' ? route('fishes.show', $fish) : route('fishes.index') }}" class="btn btn-abu">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
