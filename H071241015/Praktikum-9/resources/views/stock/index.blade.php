@extends('layout.app')

@section('title', 'Manajemen Stok')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manajemen Stok</h2>
        <a href="{{ route('stock.transfer.create') }}" class="btn btn-success">
            <i class="bi bi-truck"></i> Transfer Stok
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('stock.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="warehouse_id" class="form-label">
                        <strong>Pilih Gudang untuk Melihat Stok</strong>
                    </label>
                    <select name="warehouse_id" id="warehouse_id" class="form-select">
                        <option value="">-- Pilih Gudang --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" 
                                    {{ $selectedWarehouse && $selectedWarehouse->id == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }} ({{ $warehouse->location ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Tampilkan Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hasil Tabel Stok --}}
    @if($selectedWarehouse)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Daftar Stok di: {{ $selectedWarehouse->name }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Total Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocks as $product)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <strong>{{ $product->pivot->quantity }}</strong> unit
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        Belum ada data stok untuk produk apapun di gudang ini.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-secondary text-center">
            <i class="bi bi-info-circle me-2"></i>
            Silakan pilih gudang terlebih dahulu untuk menampilkan data stok.
        </div>
    @endif
@endsection