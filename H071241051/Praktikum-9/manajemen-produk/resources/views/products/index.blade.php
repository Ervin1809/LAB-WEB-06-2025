@extends('layouts.app')

@section('content')
    <h2>Manajemen Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk Baru</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $key => $product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                    <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus? Ini akan menghapus detail & stok produk ini.');">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Show</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
@endsection