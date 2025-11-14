@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Form Transfer Stok</div>
                <div class="card-body">
                    <form action="{{ route('stocks.transfer.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Gudang</label>
                            <select class="form-select @error('warehouse_id') is-invalid @enderror" 
                                    id="warehouse_id" name="warehouse_id">
                                <option value="">-- Pilih Gudang Tujuan --</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                    id="product_id" name="product_id">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Kuantitas</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" value="{{ old('quantity') }}">
                            <div class="form-text">
                                Isi nilai positif (misal: <strong>10</strong>) untuk menambah stok (barang masuk).<br>
                                Isi nilai negatif (misal: <strong>-5</strong>) untuk mengurangi stok (barang keluar).
                            </div>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Proses Transfer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection