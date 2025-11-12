@extends('layout.app')

@section('title', 'Form Transfer Stok')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Transfer Stok (Masuk/Keluar)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('stock.transfer.store') }}" method="POST">
                        @csrf
                        
                        {{-- Gudang --}}
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Gudang Tujuan</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Produk --}}
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Kuantitas --}}
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="{{ old('quantity') }}" placeholder="Contoh: 10 atau -5" required>
                            <div class="form-text">
                                <i class="bi bi-plus-circle-fill text-success"></i> 
                                Gunakan angka positif (misal: <strong>10</strong>) untuk <strong>menambah</strong> stok (Stok Masuk).
                            </div>
                            <div class="form-text">
                                <i class="bi bi-dash-circle-fill text-danger"></i> 
                                Gunakan angka negatif (misal: <strong>-5</strong>) untuk <strong>mengurangi</strong> stok (Stok Keluar).
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg"></i> Proses Transfer
                            </button>
                            <a href="{{ route('stock.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection