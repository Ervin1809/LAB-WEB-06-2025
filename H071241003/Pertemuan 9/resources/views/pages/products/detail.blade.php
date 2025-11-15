@extends('layouts.master')

@section('konten')
    <h1>Detail Produk</h1>
    <hr>
    <div class="card">
        <div class="card-header">
            Detail Produk {{$produk->nama_produk}}
        </div>
        <div class="card-body">
            <img src="https://placehold.co/600x400" class="img-fluid" alt="">
            <p>Nama Produk : {{$produk->nama_produk}}</p>
            <p>Harga : {{$produk->harga}}</p>
            <p>Deskripsi : {{$produk->deskripsi_produk}}</p>
            <p>Kategori : Barang Elektronik</p>
            <p>Stok : Tersedia 3</p>
            <a href="/product" class="btn btn-primary">Kembali Ke Produk</a>
        </div>
    </div>
@endsection
