@extends('layouts.app')
@section('title','Buat Produk')
@section('content')
<div class="card p-4">
  <h4>Buat Produk</h4>
  <form action="{{ route('products.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-6 mb-3"><label class="form-label">Nama</label>
        <input name="name" class="form-control" value="{{ old('name') }}" required></div>

      <div class="col-md-6 mb-3"><label class="form-label">Harga</label>
        <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}" required></div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
          <option value="">-- Pilih --</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-12 mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
      </div>

      <div class="col-md-4 mb-3"><label class="form-label">Berat (kg)</label>
        <input name="weight" type="number" step="0.01" class="form-control" value="{{ old('weight') }}" required></div>

      <div class="col-md-4 mb-3"><label class="form-label">Size</label>
        <input name="size" class="form-control" value="{{ old('size') }}"></div>
    </div>

    <button class="btn btn-brown">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>
@endsection
