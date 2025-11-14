@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Manajemen Stok Gudang</h1>
        <a href="{{ route('stocks.transfer.create') }}" class="btn btn-success">Transfer Stok</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Filter Stok per Gudang</div>
        <div class="card-body">
            <form action="{{ route('stocks.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-9">
                        <select name="warehouse_id" class="form-select">
                            <option value="">-- Tampilkan Semua Gudang --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ $selectedWarehouseId == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Daftar Stok Produk
            @if($selectedWarehouseId && $warehouses->find($selectedWarehouseId))
                (Gudang: {{ $warehouses->find($selectedWarehouseId)->name }})
            @else
                (Semua Gudang)
            @endif
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Gudang</th>
                        <th>Nama Produk</th>
                        <th>Kuantitas (Stok)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->warehouse_name }}</td>
                            <td>{{ $stock->product_name }}</td>
                            <td>{{ $stock->quantity }} unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                @if($selectedWarehouseId)
                                    Tidak ada stok di gudang ini.
                                @else
                                    Belum ada data stok di gudang manapun.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="2" class="text-end">Total (SUM) Stok (di gudang ini):</th>
                        <th>{{ $totalStock }} unit</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection