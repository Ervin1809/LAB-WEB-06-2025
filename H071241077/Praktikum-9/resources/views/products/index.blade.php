@extends('layouts.app')
@section('title','Produk')
@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Produk</h4>
    <a href="{{ route('products.create') }}" class="btn btn-brown">+ Tambah Produk</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Kategori</th>
          <th scope="col">Harga</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
        <tr>
          <td>{{ $p->name }}</td>
          <td>{{ $p->category?->name ?? '-' }}</td>
          <td>Rp {{ number_format($p->price, 2, ',', '.') }}</td>
          <td>
            <a class="btn btn-sm btn-primary me-1" href="{{ route('products.show', $p) }}">Lihat</a>
            <a class="btn btn-sm btn-warning text-white me-1" href="{{ route('products.edit', $p) }}">Edit</a>
            <form action="{{ route('products.destroy', $p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus produk?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection
