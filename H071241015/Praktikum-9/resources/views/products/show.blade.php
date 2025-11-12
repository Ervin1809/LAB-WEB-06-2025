@extends('layout.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ $product->name }}</h4>
                            <p class="text-muted">{{ $product->productDetail->description ?? 'Tidak ada deskripsi' }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Harga:</strong></td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kategori:</strong></td>
                                            <td>{{ $product->category->name ?? 'Tidak ada kategori' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID:</strong></td>
                                            <td>{{ $product->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diupdate:</strong></td>
                                            <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title">Spesifikasi Produk</h6>
                                    <p><strong>Berat:</strong> {{ $product->productDetail->weight ?? '-' }} kg</p>
                                    <p><strong>Ukuran:</strong> {{ $product->productDetail->size ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <div class="float-end">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Gudang dan Stok Produk -->
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5>Stok Produk per Gudang</h5>
                </div>
                <div class="card-body">
                    @if($product->warehouses->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Gudang</th>
                                    <th>Lokasi</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->location ?? '-' }}</td>
                                        <td>{{ $warehouse->pivot->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Produk ini tidak tersedia di gudang manapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection