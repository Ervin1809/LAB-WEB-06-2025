@extends('layouts.app')
@section('title','Edit Gudang')
@section('content')
<div class="card p-4">
  <h4>Edit Gudang</h4>
  <form action="{{ route('warehouses.update',$warehouse) }}" method="post">
    @csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Nama</label>
      <input name="name" class="form-control" value="{{ old('name',$warehouse->name) }}" required></div>
    <div class="mb-3"><label class="form-label">Lokasi</label>
      <textarea name="location" class="form-control">{{ old('location',$warehouse->location) }}</textarea></div>
    <button class="btn btn-brown">Update</button>
  </form>
</div>
@endsection
