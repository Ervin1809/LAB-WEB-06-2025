@extends('layouts.app')

@section('content')
    <h2>Form Transfer Stok</h2>
    <p>Gunakan nilai positif (mis: 10) untuk menambah stok, dan nilai negatif (mis: -5) untuk mengurangi stok.</p>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('stock.transfer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="warehouse_id" class="form-label">Gudang Tujuan</label>
            <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                <option value="">Pilih Gudang</option>
                @foreach ($warehouses as $wh)
                    <option value="{{ $wh->id }}" {{ old('warehouse_id') == $wh->id ? 'selected' : '' }}>
                        {{ $wh->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="product_id" class="form-label">Produk</label>
            <select class="form-select" id="product_id" name="product_id" required>
                <option value="">Pilih Produk</option>
                 @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah (+/-)</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
            <small class="form-text text-muted">Contoh: 10 (menambah 10) atau -5 (mengurangi 5)</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Proses Transfer</button>
        <a href="{{ route('stock.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection