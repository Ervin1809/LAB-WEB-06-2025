@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk Baru</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <div class="card mb-3">
            <div class="card-header">Informasi Utama Produk</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori (Opsional)</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" step="0.01">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Detail Produk</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Berat (kg)</label>
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                               id="weight" name="weight" value="{{ old('weight') }}" step="0.01">
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Ukuran (Opsional)</label>
                        <input type="text" class="form-control @error('size') is-invalid @enderror" 
                               id="size" name="size" value="{{ old('size') }}">
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection