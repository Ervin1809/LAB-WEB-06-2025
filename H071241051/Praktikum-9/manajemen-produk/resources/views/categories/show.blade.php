@extends('layouts.app')

@section('content')
    <h2>Detail Kategori</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text">
                <strong>Deskripsi:</strong><br>
                {{ $category->description ?? 'Tidak ada deskripsi.' }}
            </p>
            <hr>
            <p><strong>Dibuat pada:</strong> {{ $category->created_at->format('d F Y, H:i:s') }}</p>
            <p><strong>Diupdate pada:</strong> {{ $category->updated_at->format('d F Y, H:i:s') }}</p>
        </div>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Kembali ke List</a>
@endsection