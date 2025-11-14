@extends('layouts.app')

@section('content')
    <h2>Detail Produk: {{ $product->name }}</h2>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Informasi Utama</h4>
                    <p><strong>Nama:</strong> {{ $product->name }}</p>
                    <p><strong>Kategori:</strong> {{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Informasi Tambahan</h4>
                    <p><strong>Berat:</strong> {{ $product->productDetail->weight ?? '-' }} kg</p>
                    <p><strong>Ukuran:</strong> {{ $product->productDetail->size ?? '-' }}</p>
                </div>
            </div>
            <hr>
            <h5>Deskripsi</h5>
            <p>{{ $product->productDetail->description ?? 'Tidak ada deskripsi.' }}</p>
            <hr>
            <p><strong>Dibuat pada:</strong> {{ $product->created_at->format('d F Y, H:i:s') }}</p>
            <p><strong>Diupdate pada:</strong> {{ $product->updated_at->format('d F Y, H:i:s') }}</p>

        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali ke List</a>
@endsection