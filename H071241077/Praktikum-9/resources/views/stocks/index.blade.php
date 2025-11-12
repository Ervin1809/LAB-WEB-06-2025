@extends('layouts.app')
@section('title','Stok')
@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Manajemen Stok</h4>
    <div>
      <a href="{{ route('stocks.transfer') }}" class="btn btn-brown">Transfer Stok</a>
    </div>
  </div>

  <form method="get" class="mb-3">
    <div class="row g-2 align-items-center">
      <div class="col-auto">
        <select name="warehouse_id" class="form-select">
          <option value="">-- Tampilkan Semua Gudang --</option>
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}" @selected($selectedWarehouse==$w->id)>{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-secondary">Filter</button>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-striped text-center align-middle" style="table-layout: fixed; width: 100%;">
      <colgroup>
        <col style="width: 40%;">
        <col style="width: 30%;">
        <col style="width: 30%;">
      </colgroup>
      <thead class="table-light">
        <tr>
          <th scope="col">Produk</th>
          <th scope="col">Gudang</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
        <tr>
          <td>{{ $it->product_name }}</td>
          <td>{{ $it->warehouse_name }}</td>
          <td>{{ $it->total }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3">Tidak ada data</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
