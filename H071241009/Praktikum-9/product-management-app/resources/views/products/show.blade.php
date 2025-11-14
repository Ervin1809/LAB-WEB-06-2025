@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detail Produk: {{ $product->name }}</h1>
        <div>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Informasi Utama
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>ID Produk:</strong> {{ $product->id }}
                </li>
                <li class="list-group-item">
                    <strong>Nama Produk:</strong> {{ $product->name }}
                </li>
                <li class="list-group-item">
                    <strong>Kategori:</strong> {{ $product->category ? $product->category->name : 'N/A' }}
                </li>
                <li class="list-group-item">
                    <strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}
                </li>
            </ul>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Detail Tambahan
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Deskripsi:</strong>
                    <p>{{ $product->detail?->description ?? '-' }}</p>
                </li>
                <li class="list-group-item">
                    <strong>Berat:</strong> {{ $product->detail?->weight ?? '-' }} kg
                </li>
                <li class="list-group-item">
                    <strong>Ukuran:</strong> {{ $product->detail?->size ?? '-' }}
                </li>
            </ul>
        </div>
        <div class="card-footer text-muted">
            Dibuat pada: {{ $product->created_at->format('d M Y, H:i') }} <br>
            Diperbarui pada: {{ $product->updated_at->format('d M Y, H:i') }}
        </div>
    </div>
</div>
@endsection