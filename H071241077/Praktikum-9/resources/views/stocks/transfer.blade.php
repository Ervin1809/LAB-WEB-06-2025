@extends('layouts.app')

@section('title', 'Tambah/Kurang Stok')

@section('content')
<div class="card p-4">
    {{-- Judul disesuaikan agar lebih eksplisit sesuai fungsi (Tambah/Kurang) --}}
    <h4 class="mb-4">Tambah/Kurang Stok di Gudang</h4> 
    
    {{-- Pastikan rute ini mengarah ke StockController@store --}}
    <form action="{{ route('stocks.transfer.store') }}" method="POST">
        @csrf
        
        <div class="row">
            {{-- Dropdown Gudang --}}
            <div class="col-md-6 mb-3">
                <label for="warehouse_id" class="form-label">Gudang</label>
                <select name="warehouse_id" id="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Gudang --</option>
                    @foreach($warehouses as $w)
                        <option value="{{ $w->id }}" @selected(old('warehouse_id') == $w->id)>
                            {{ $w->name }}
                        </option>
                    @endforeach
                </select>
                @error('warehouse_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Dropdown Produk --}}
            <div class="col-md-6 mb-3">
                <label for="product_id" class="form-label">Produk</label>
                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Kuantitas --}}
            <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">Jumlah (- untuk keluar)</label>
                <input type="number" 
                       name="quantity" 
                       id="quantity" 
                       class="form-control @error('quantity') is-invalid @enderror" 
                       value="{{ old('quantity', 0) }}" 
                       required
                       min="-99999" {{-- Batasan minimal agar pengguna tahu boleh negatif --}}
                       max="99999"  {{-- Batasan maksimal --}}
                > 
                <div class="form-text">Jika ingin mengurangi stok, masukkan angka negatif, contoh: -10</div>
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-brown">Proses</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection