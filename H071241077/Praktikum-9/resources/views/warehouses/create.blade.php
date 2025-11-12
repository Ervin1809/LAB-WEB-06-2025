@extends('layouts.app')
@section('title','Tambah Gudang')
@section('content')
<div class="card p-4">
  <h4>Tambah Gudang</h4>
  <form action="{{ route('warehouses.store') }}" method="post">
    @csrf
    <div class="mb-3"><label class="form-label">Nama</label>
      <input name="name" class="form-control" value="{{ old('name') }}" required></div>
    <div class="mb-3"><label class="form-label">Lokasi</label>
      <textarea name="location" class="form-control">{{ old('location') }}</textarea></div>
    <button class="btn btn-brown">Simpan</button>
    {{-- Tombol Batal untuk kembali ke index gudang --}}
    <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>
@endsection
