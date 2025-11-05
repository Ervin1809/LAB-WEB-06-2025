@extends('layouts.app')

@section('title', 'Fish List - Fish It Roblox')

@section('content')
<div class="space-y-8">
    {{-- Header with Gaming Aesthetic --}}
    <div class="text-center relative">
        <div class="absolute -inset-4 bg-gradient-to-r from-cyan-500/10 to-purple-500/10 rounded-2xl blur-lg -z-10"></div>
        <h1 class="text-4xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 font-orbitron tracking-wider">
            FISH DATABASE
        </h1>
        <p class="mt-2 text-lg text-slate-300 font-orbitron">Manage fish data list</p>
    </div>

    {{-- Filter Card with Gaming Aesthetic --}}
    <div class="rounded-xl border border-slate-700 bg-slate-800/60 p-4 md:p-6 backdrop-blur-sm shadow-lg shadow-cyan-500/10 transition-all duration-300 hover:shadow-cyan-500/20">
        <form method="GET" action="{{ route('fishes.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5 lg:gap-6">
            <div class="relative">
                <label for="search" class="block text-sm font-medium text-cyan-400 mb-1 font-orbitron tracking-wide">Search Fish</label>
                <div class="relative">
                    <input type="text" id="search" name="search" class="w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 pl-10 py-2 transition-all duration-300" placeholder="e.g., Marlin" value="{{ request('search') }}">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-cyan-400"></i>
                </div>
            </div>
            <div>
                <label for="rarity" class="block text-sm font-medium text-cyan-400 mb-1 font-orbitron tracking-wide">Filter Rarity</label>
                <select id="rarity" name="rarity" class="w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-2 transition-all duration-300">
                    <option value="">All Rarities</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>{{ $rarity }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort" class="block text-sm font-medium text-cyan-400 mb-1 font-orbitron tracking-wide">Sort By</label>
                <select id="sort" name="sort" class="w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-2 transition-all duration-300">
                    <option value="">Default</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="sell_price_per_kg" {{ request('sort') == 'sell_price_per_kg' ? 'selected' : '' }}>Price</option>
                    <option value="catch_probability" {{ request('sort') == 'catch_probability' ? 'selected' : '' }}>Probability</option>
                </select>
            </div>
            <div>
                <label for="direction" class="block text-sm font-medium text-cyan-400 mb-1 font-orbitron tracking-wide">Order</label>
                <select id="direction" name="direction" class="w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-2 transition-all duration-300">
                    <option value="asc" {{ request('direction', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction', 'asc') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            <div class="self-end">
                <button type="submit" class="w-full flex justify-center rounded-lg border border-transparent bg-gradient-to-r from-cyan-600 to-blue-600 px-4 py-2 text-sm font-medium text-white shadow-lg hover:from-cyan-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-300 transform hover:scale-105">
                    <i class="bi bi-funnel-fill mr-2"></i> Filter
                </button>
            </div>
        </form>
        @if(request()->hasAny(['search', 'rarity', 'sort', 'direction']))
            <div class="mt-4 text-center">
                <a href="{{ route('fishes.index') }}" class="text-sm text-slate-400 hover:text-cyan-400 font-orbitron transition duration-300">&times; Reset Filters</a>
            </div>
        @endif
    </div>

    {{-- Fish Grid - More gaming-like design --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($fishes->count() > 0)
            @foreach($fishes as $fish)
            <div class="bg-slate-800/60 border border-slate-700 rounded-xl p-5 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/10 group">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-white font-orbitron group-hover:text-cyan-300 transition duration-300">{{ $fish->name }}</h3>
                        <div class="mt-2">
                            <span class="rounded-full px-3 py-1 text-sm font-semibold text-white rarity-{{ strtolower($fish->rarity) }} transition duration-300 {{ strtolower($fish->rarity) == 'secret' ? 'glow-secret' : 'glow-' . strtolower($fish->rarity) }}">{{ $fish->rarity }}</span>
                        </div>
                    </div>
                    <i class="bi bi-water text-3xl text-cyan-400 opacity-50 group-hover:opacity-100 group-hover:text-cyan-300 transition duration-300"></i>
                </div>
                
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-orbitron">Weight:</span>
                        <span class="text-white font-medium">{{ $fish->weight_range }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-orbitron">Price/kg:</span>
                        <div class="flex items-center">
                            <i class="bi bi-coin text-yellow-400 mr-1"></i>
                            <span class="text-white font-medium">{{ $fish->formatted_price }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-orbitron">Catch %:</span>
                        <span class="text-white font-medium">{{ $fish->catch_probability }}%</span>
                    </div>
                </div>
                
                <div class="mt-5 flex space-x-2">
                    <a href="{{ route('fishes.show', $fish) }}" class="flex-1 text-center py-2 rounded-lg bg-slate-700 hover:bg-cyan-600 text-slate-200 hover:text-white transition duration-300 font-orbitron">
                        <i class="bi bi-eye mr-1"></i> View
                    </a>
                    <a href="{{ route('fishes.edit', $fish) }}" class="flex-1 text-center py-2 rounded-lg bg-slate-700 hover:bg-yellow-600 text-slate-200 hover:text-white transition duration-300 font-orbitron">
                        <i class="bi bi-pencil mr-1"></i> Edit
                    </a>
                    <div x-data="{ modalOpen: false }" class="relative flex-1">
                        <button @click="modalOpen = true" class="w-full py-2 rounded-lg bg-slate-700 hover:bg-red-600 text-slate-200 hover:text-white transition duration-300 font-orbitron">
                            <i class="bi bi-trash mr-1"></i> Delete
                        </button>
                        
                        <div x-show="modalOpen" x-cloak @click.away="modalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <div class="w-full max-w-md rounded-xl border border-slate-700 bg-slate-800 p-6 backdrop-blur-md shadow-xl shadow-cyan-500/20">
                                <h3 class="text-lg font-bold text-white font-orbitron">CONFIRM DELETION</h3>
                                <p class="mt-2 text-sm text-slate-400">Are you sure you want to delete</p>
                                <p class="mt-1 text-m font-bold text-white"><strong>{{ $fish->name }}</strong></p>
                                <p class="mt-2 text-sm text-slate-400">This action cannot be undone.</p>
                                <div class="mt-6 flex justify-end space-x-4">
                                    <button @click="modalOpen = false" type="button" class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-200 transition duration-300 font-orbitron">Cancel</button>
                                    <form action="{{ route('fishes.destroy', $fish) }}" method="POST" @submit.prevent="modalOpen = false; $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition duration-300 font-orbitron">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-full py-12 text-center">
                <div class="inline-block p-4 rounded-full bg-slate-800/50 border border-slate-700">
                    <i class="bi bi-water text-6xl text-slate-600"></i>
                </div>
                <h3 class="mt-4 text-xl font-bold text-white font-orbitron">No Fish Found</h3>
                <p class="text-slate-400">Add a new fish or adjust your search filters.</p>
                <a href="{{ route('fishes.create') }}" class="mt-4 inline-block rounded-lg bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-3 text-sm font-medium text-white shadow-lg hover:from-cyan-700 hover:to-blue-700 transition-all duration-300 font-orbitron">
                    Add New Fish
                </a>
            </div>
        @endif
    </div>
    
    @if ($fishes->hasPages())
        <div class="border-t border-slate-700 bg-slate-800/50 px-4 py-3 rounded-b-lg">
            <div class="flex justify-center">
                {{ $fishes->links() }}
            </div>
        </div>
    @endif
</div>
@endsection