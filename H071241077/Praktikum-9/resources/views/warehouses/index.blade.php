@extends('layouts.app')
@section('title','Gudang')
@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Gudang</h4>
    <a href="{{ route('warehouses.create') }}" class="btn btn-brown">+ Tambah Gudang</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Lokasi</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($warehouses as $w)
        <tr>
          <td>{{ $w->name }}</td>
          <td>{{ Str::limit($w->location,80) }}</td>
          <td>
            <a class="btn btn-sm btn-warning text-white me-1" href="{{ route('warehouses.edit',$w) }}">Edit</a>
            <form action="{{ route('warehouses.destroy',$w) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus gudang?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
      {{ $warehouses->links() }}
    </div>
  </div>
</div>
@endsection
