@extends('layouts.master')

@section('title','Daftar Kategori')

@section('konten')
    {{-- Ganti /kategori -> /categories --}}
    <a href="/categories/create" class="btn btn-primary mb-3">Tambah Kategori</a>
    @if (session('message'))
        <div class="alert alert-primary">{{ session('message') }}</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between  align-items-center">
            Daftar Kategori Produk
            <div class="d-flex gap-2">
                @if (Request()->keyword != '')
                    {{-- Ganti /kategori -> /categories --}}
                    <a href="/categories" class="btn btn-info">Reset</a>
                @endif
                <form class="input-group" style="width: 350px">
                    <input type="text" class="form-control" value="{{ Request()->keyword }}" name="keyword"
                        placeholder="Cari data kategori">
                    <button class="btn btn-success" type="submit">Cari Data</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ganti $kategori -> $categories --}}
                    @forelse ($categories as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            {{-- Ganti $item->nama_kategori -> $item->name --}}
                            <td>{{ $item->name }}</td>
                            {{-- Ganti $item->deskripsi -> $item->description --}}
                            <td>{{ $item->description }}</td>
                            <td>
                                {{-- Ganti /kategori -> /categories dan $item->id_kategori -> $item->id --}}
                                <a href="/categories/{{ $item->id }}/edit" class="btn btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#hapus{{ $item->id }}">Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Yang Anda Cari Tidak Ada!!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ganti $kategori -> $categories --}}
    @foreach ($categories as $item)
        {{-- Ganti $item->id_kategori -> $item->id --}}
        <div class="modal fade" id="hapus{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                {{-- Ganti action /kategori -> /categories dan $item->id_kategori -> $item->id --}}
                <form action="/categories/{{ $item->id }}" method="POST" class="modal-content">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Ganti $item->nama_kategori -> $item->name --}}
                        Apakah anda yakin ingin menghapus kategori {{ $item->name }}??
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection