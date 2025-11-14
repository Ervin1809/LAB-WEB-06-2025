@extends('layouts.app')

@section('content')
    <h2>Manajemen Stok</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('stock.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <label for="warehouse_id" class="form-label">Pilih Gudang</label>
                        <select class="form-select" id="warehouse_id" name="warehouse_id">
                            <option value="">Pilih satu...</option>
                            @foreach ($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ $selectedWarehouseId == $wh->id ? 'selected' : '' }}>
                                    {{ $wh->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6" style="align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">Tampilkan Stok</button>
                        <a href="{{ route('stock.transfer.create') }}" class="btn btn-success">Transfer Stok</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($warehouse)
        <h3>Stok di: {{ $warehouse->name }}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Total Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($warehouse->products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td><strong>{{ $product->pivot->quantity }}</strong> Pcs</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada stok produk di gudang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Silakan pilih gudang untuk melihat daftar stok.
        </div>
    @endif
@endsection