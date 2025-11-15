@extends('layouts.master')

@section('konten')
    <h1>Update Daftar Produk</h1>
    <hr>
    <div class="card">
        <div class="card-header">Update Data Produk</div>
        <div class="card-body">
            <form action="/product/{{ $data->id_produk }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" value="{{ $data->nama_produk }}">
                            @error('nama_produk')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Harga Produk </label>
                            <input type="text" class="form-control" name="harga_produk" value="{{ $data->harga }}">
                            @error('harga_produk')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Stok </label>
                            <input type="text" class="form-control" name="stok" value="{{ $data->stok }}">
                            @error('stok')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Kategori </label>
                            <select class="form-select" aria-label="Default select example" name="kategori">

                                @foreach ($kategori as $item)
                                    @if ($item->id_kategori == $data->kategori_id)
                                        <option value="{{ $item->id_kategori }}" selected>{{ $item->nama_kategori }}
                                        </option>
                                    @else
                                        <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="deskripsi" id="floatingTextarea2" style="height: 100px">{{ $data->deskripsi_produk }}</textarea>
                            <label for="floatingTextarea2">Deskripsi Produk</label>
                            @error('deskripsi')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
