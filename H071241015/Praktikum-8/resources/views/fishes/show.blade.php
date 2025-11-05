@extends('layouts.app')

@section('title', 'Detail Ikan: ' . $fish->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detail Ikan: {{ $fish->name }}</h1>
        <div>
            <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');"> {{-- --}}
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $fish->id }}</dd>

                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $fish->name }}</dd>

                        <dt class="col-sm-4">Rarity</dt>
                        <dd class="col-sm-8">{{ $fish->rarity }}</dd>

                        <dt class="col-sm-4">Berat Min</dt>
                        <dd class="col-sm-8">{{ $fish->base_weight_min }} kg</dd>

                        <dt class="col-sm-4">Berat Max</dt>
                        <dd class="col-sm-8">{{ $fish->base_weight_max }} kg</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">Harga Jual / kg</dt>
                        <dd class="col-sm-7">{{ number_format($fish->sell_price_per_kg) }} Coins</dd>

                        <dt class="col-sm-5">Peluang Tangkap</dt>
                        <dd class="col-sm-7">{{ $fish->catch_probability }}%</dd>

                        <dt classs="col-sm-5">Dibuat Pada</dt>
                        <dd class="col-sm-7">{{ $fish->created_at->format('d M Y, H:i') }}</dd>

                        <dt class="col-sm-5">Diupdate Pada</dt>
                        <dd class="col-sm-7">{{ $fish->updated_at->format('d M Y, H:i') }}</dd>
                    </dl>
                </div>
                <div class="col-12">
                    <hr>
                    <p><strong>Deskripsi:</strong></p>
                    <p>{{ $fish->description ?? '(Tidak ada deskripsi)' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection