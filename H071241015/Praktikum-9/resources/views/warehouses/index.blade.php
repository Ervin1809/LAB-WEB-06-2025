@extends('layout.app')

@section('title', 'Daftar Gudang')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Gudang</h2>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Gudang
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Gudang</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $warehouses->firstItem() - 1 }}</th>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->location ?? '-' }}</td>
                            <td>
                                <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus gudang ini? Stok di gudang ini akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data gudang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $warehouses->links() }}
        </div>
    </div>
@endsection