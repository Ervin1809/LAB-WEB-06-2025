@extends('layout.app')

@section('title', 'Tambah Produk Baru')

@section('content')
    <h2>Tambah Produk Baru</h2>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Kolom Kiri: Info Produk & Detail --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5>Data Utama Produk</h5>
                    </div>
                    <div class="card-body">
                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required>
                        </div>
                        
                        {{-- Deskripsi (dari ProductDetail) --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="5">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header">
                        <h5>Spesifikasi (Detail Produk)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Berat (dari ProductDetail) --}}
                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label">Berat (kg)</label>
                                <input type="number" class="form-control" id="weight" name="weight" 
                                       value="{{ old('weight') }}" step="0.01" required>
                                <div class="form-text">Contoh: 1.50</div>
                            </div>
                            
                            {{-- Ukuran (dari ProductDetail) --}}
                            <div class="col-md-6 mb-3">
                                <label for="size" class="form-label">Ukuran / Dimensi</label>
                                <input type="text" class="form-control" id="size" name="size" 
                                       value="{{ old('size') }}">
                                <div class="form-text">Contoh: 15 inch atau 20x10x5 cm</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Harga & Kategori --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5>Harga & Kategori</h5>
                    </div>
                    <div class="card-body">
                        {{-- Harga --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   value="{{ old('price') }}" step="0.01" required>
                        </div>
                        
                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">-- Tidak Ada Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary w-100 mt-2">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection