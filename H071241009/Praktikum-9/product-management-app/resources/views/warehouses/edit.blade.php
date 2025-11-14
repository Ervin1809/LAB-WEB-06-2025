@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gudang: {{ $warehouse->name }}</h1>

    <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $warehouse->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi (Opsional)</label>
            <textarea class="form-control @error('location') is-invalid @enderror" 
                      id="location" name="location" rows="3">{{ old('location', $warehouse->location) }}</textarea>
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection