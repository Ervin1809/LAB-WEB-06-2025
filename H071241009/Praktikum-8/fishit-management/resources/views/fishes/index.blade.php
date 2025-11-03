@extends('layouts.app')

@section('content')
    <h2>Daftar Ikan (Fish Database)</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card my-3">
        <div class="card-body">
            <form action="{{ route('fishes.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <label for="rarity" class="form-label">Filter berdasarkan Rarity:</label>
                        <select name="rarity" id="rarity" class="form-select">
                            <option value="">Semua Rarity</option>
                            <option value="Common" {{ request('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                            <option value="Uncommon" {{ request('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                            <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                            <option value="Epic" {{ request('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
                            <option value="Legendary" {{ request('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                            <option value="Mythic" {{ request('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                            <option value="Secret" {{ request('rarity') == 'Secret' ? 'selected' : '' }}>Secret</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No.</th> <th>Nama</th>
                    <th>Rarity</th>
                    <th>Harga/kg (Coins)</th>
                    <th>Peluang (%)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fishes as $fish)
                    <tr>
                        <td>{{ $fishes->firstItem() + $loop->index }}</td>
                        
                        <td>{{ $fish->name }}</td>
                        <td>{{ $fish->rarity }}</td>
                        <td>{{ $fish->sell_price_per_kg }}</td>
                        <td>{{ $fish->catch_probability }}</td>
                        <td>
                            <a href="{{ route('fishes.show', $fish) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data ikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $fishes->appends(request()->query())->links() }}
    </div>
@endsection