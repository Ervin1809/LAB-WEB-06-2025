@extends('layouts.app')
@section('title','Detail Produk')
@section('content')
<div class="card p-4">
  <h4>{{ $product->name }}</h4>
  <p><strong>Kategori:</strong> {{ $product->category?->name ?? '-' }}</p>
  <p><strong>Harga:</strong> Rp {{ number_format($product->price,2,',','.') }}</p>

  <hr>
  <h5>Detail</h5>
  <p><strong>Deskripsi:</strong> {{ $product->detail->description ?? '-' }}</p>
  <p><strong>Berat:</strong> {{ $product->detail->weight ?? '-' }} kg</p>
  <p><strong>Size:</strong> {{ $product->detail->size ?? '-' }}</p>

  <hr>
  <h5>Stok per Gudang</h5>

  {{-- Jika belum ada data stok --}}
  @if($product->warehouses->isEmpty())
    <p class="text-muted fst-italic text-center mt-2">Tidak ada info stok</p>
  @else
    <table class="table table-borderless text-center align-middle" style="table-layout: fixed; width: 100%;">
      <thead>
        <tr>
          <th>Gudang</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @foreach($product->warehouses as $w)
          <tr>
            <td>{{ $w->name }}</td>
            <td>{{ $w->pivot->quantity }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
</div>
@endsection
