@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Gudang (Warehouse)</h1>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">Tambah Gudang Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Nama Gudang</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($warehouses as $warehouse)
                <tr>
                    <td>{{ ($warehouses->firstItem() + $loop->index) }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location ?? '-' }}</td>
                    <td>
                        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Anda yakin ingin menghapus gudang ini? Seluruh data stok di gudang ini akan ikut terhapus.')">
                                Hapus
                            </button>
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

    <div class="d-flex justify-content-center mt-3">
        {{ $warehouses->links() }}
    </div>
</div>
@endsection