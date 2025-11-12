@extends('layout.app')

@section('title', 'Edit Gudang')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Gudang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Gudang</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name', $warehouse->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi (Opsional)</label>
                            <textarea class="form-control" id="location" name="location"
                                      rows="3">{{ old('location', $warehouse->location) }}</textarea>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection