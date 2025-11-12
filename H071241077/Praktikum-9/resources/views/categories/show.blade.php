@extends('layouts.app')
@section('title','Detail Kategori')
@section('content')
<div class="card p-4">
  <h4>{{ $category->name }}</h4>
  <p>{{ $category->description ?: '-' }}</p>
  <p><small>Dibuat: {{ $category->created_at->format('d M Y H:i') }}</small></p>
  <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
@endsection
