@extends('layouts.app')

@section('content')
    <h1>Tambah Ikan Baru</h1>

    <form action="{{ route('fishes.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Ikan:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label for="rarity">Rarity:</label>
            <select id="rarity" name="rarity" class="form-control" required>
                <option value="">-- Pilih Rarity --</option>
                @foreach ($rarities as $r)
                    <option value="{{ $r }}" {{ old('rarity') == $r ? 'selected' : '' }}>{{ $r }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="base_weight_min">Berat Minimum (kg):</label>
            <input type="number" step="0.01" id="base_weight_min" name="base_weight_min" class="form-control" value="{{ old('base_weight_min') }}" required>
        </div>
        
        <div class="form-group">
            <label for="base_weight_max">Berat Maksimum (kg):</label>
            <input type="number" step="0.01" id="base_weight_max" name="base_weight_max" class="form-control" value="{{ old('base_weight_max') }}" required>
        </div>
        
        <div class="form-group">
            <label for="sell_price_per_kg">Harga Jual per kg (Coins):</label>
            <input type="number" id="sell_price_per_kg" name="sell_price_per_kg" class="form-control" value="{{ old('sell_price_per_kg') }}" required>
        </div>
        
        <div class="form-group">
            <label for="catch_probability">Peluang Tertangkap (%):</label>
            <input type="number" step="0.01" id="catch_probability" name="catch_probability" class="form-control" value="{{ old('catch_probability') }}" required placeholder="Contoh: 50.25">
        </div>
        
        <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Ikan Baru</button>
        <a href="{{ route('fishes.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Batal</a>
    </form>
@endsection