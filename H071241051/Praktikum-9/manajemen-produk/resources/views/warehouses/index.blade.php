@extends('layouts.app')

@section('content')
    <h2>Manajemen Gudang</h2>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">Tambah Gudang Baru</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Gudang</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($warehouses as $key => $warehouse)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location ?? '-' }}</td>
                    <td>
                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" onsubmit="return confirm('Yakin hapus? Ini akan menghapus semua stok di gudang ini.');">
                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data gudang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection