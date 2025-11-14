@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Produk</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ ($products->firstItem() + $loop->index) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Anda yakin ingin menghapus produk ini? Ini akan menghapus detail dan data stok terkait.')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links() }}
    </div>
    
    </div>
@endsection