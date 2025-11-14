@extends('layouts.app')

@section('content')
    <h2>Edit Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-header">Detail Produk Utama</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk*</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="mb-3">
                            <label for="price" class="form-label">Harga*</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Detail Tambahan</div>
            <div class="card-body">
                 <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lengkap</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->productDetail->description ?? '') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat (kg)*</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight', $product->productDetail->weight ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="size" class="form-label">Ukuran (Contoh: 15 inch)</label>
                            <input type="text" class="form-control" id="size" name="size" value="{{ old('size', $product->productDetail->size ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Produk</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
@endsection