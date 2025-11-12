@extends('layouts.app')
@section('title','Edit Kategori')
@section('content')
<div class="card p-4">
  <h4>Edit Kategori</h4>
  <form action="{{ route('categories.update',$category) }}" method="post">
    @csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Nama</label>
      <input type="text" name="name" value="{{ old('name',$category->name) }}" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control">{{ old('description',$category->description) }}</textarea></div>
    <button class="btn btn-brown">Update</button>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>
@endsection
