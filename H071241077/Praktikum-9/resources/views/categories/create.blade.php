@extends('layouts.app')
@section('title','Buat Kategori')
@section('content')
<div class="card p-4">
  <h4>Buat Kategori</h4>
  <form action="{{ route('categories.store') }}" method="post">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>
    <button class="btn btn-brown">Simpan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>
@endsection
