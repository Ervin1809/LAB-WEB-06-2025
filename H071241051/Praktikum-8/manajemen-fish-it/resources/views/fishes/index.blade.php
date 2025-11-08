@extends('layouts.app')

@section('content')
    <h1>Database Ikan Fish It</h1>

    <form method="GET" action="{{ route('fishes.index') }}" class="mb-3">
        <div class="form-group" style="max-width: 300px;">
            <label for="rarity">Filter Rarity:</label>
            <select name="rarity" id="rarity" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Rarity</option>
                @foreach ($rarities as $r)
                    <option value="{{ $r }}" {{ $rarity == $r ? 'selected' : '' }}>
                        {{ $r }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Rarity</th>
                    <th>Harga/kg</th>
                    <th>Peluang (%)</th>
                    <th style="width: 280px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fishes as $fish)
                    <tr>
                        <td>{{ $fish->id }}</td>
                        <td>{{ $fish->name }}</td>
                        <td>{{ $fish->rarity }}</td>
                        <td>{{ $fish->sell_price_per_kg }} Coins</td>
                        <td>{{ $fish->catch_probability }}%</td>
                        <td>
                            <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
                            
                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan {{ $fish->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Data ikan masih kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $fishes->appends(['rarity' => $rarity])->links() }}
    </div>

@endsection