@extends('layouts.app')
@section('title','Kategori')
@section('content')
<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Kategori</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-brown">+ Tambah Kategori</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Deskripsi</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $c)
        <tr>
          <td>{{ $c->name }}</td>
          <td>{{ Str::limit($c->description,80) }}</td>
          <td>
            <a class="btn btn-sm btn-primary me-1" href="{{ route('categories.show',$c) }}">Lihat</a>
            <a class="btn btn-sm btn-warning text-white me-1" href="{{ route('categories.edit',$c) }}">Edit</a>
            <form action="{{ route('categories.destroy',$c) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus kategori?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
      {{ $categories->links() }}
    </div>
  </div>
</div>
@endsection
