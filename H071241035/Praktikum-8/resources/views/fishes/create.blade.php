@extends('layouts.app')

@section('title', 'Add New Fish')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-xl border border-slate-700 bg-slate-800/60 backdrop-blur-sm shadow-xl shadow-cyan-500/10 overflow-hidden">
        <div class="border-b border-slate-700 bg-gradient-to-r from-slate-800/50 to-slate-900/50 p-6 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 to-purple-500/5"></div>
            <div class="relative flex items-center space-x-3">
                <i class="bi bi-plus-circle text-2xl text-cyan-400"></i>
                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400 font-orbitron tracking-wide">ADD NEW FISH</h2>
            </div>
        </div>
        <form action="{{ route('fishes.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Fish Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="Enter fish name" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <label for="rarity" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Rarity</label>
                <select name="rarity" id="rarity" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" required>
                    <option value="" disabled selected>Select rarity</option>
                     @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ old('rarity') == $rarity ? 'selected' : '' }}>{{ $rarity }}</option>
                    @endforeach
                </select>
                @error('rarity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label for="base_weight_min" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Min Weight (kg)</label>
                    <input type="number" step="0.01" name="base_weight_min" id="base_weight_min" value="{{ old('base_weight_min') }}" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="0.00" required>
                    @error('base_weight_min')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="base_weight_max" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Max Weight (kg)</label>
                    <input type="number" step="0.01" name="base_weight_max" id="base_weight_max" value="{{ old('base_weight_max') }}" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="0.00" required>
                    @error('base_weight_max')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="space-y-2">
                <label for="sell_price_per_kg" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Sell Price/kg</label>
                <input type="number" name="sell_price_per_kg" id="sell_price_per_kg" value="{{ old('sell_price_per_kg') }}" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="0" required>
                @error('sell_price_per_kg')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <label for="catch_probability" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Catch Probability (%)</label>
                <input type="number" step="0.01" name="catch_probability" id="catch_probability" value="{{ old('catch_probability') }}" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="0.00" required>
                @error('catch_probability')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-cyan-400 font-orbitron tracking-wide">Description</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-lg border border-slate-600 bg-slate-900/70 text-slate-200 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 py-3 px-4 transition-all duration-300" placeholder="Enter fish description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3 pt-5 border-t border-slate-700/50">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-gradient-to-r from-cyan-600 to-blue-600 text-white hover:from-cyan-700 hover:to-blue-700 transition-all duration-300 font-orbitron shadow-lg shadow-cyan-500/20">
                    <i class="bi bi-save mr-2"></i> Save Fish
                </button>
                <a href="{{ route('fishes.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 text-slate-200 hover:from-slate-600 hover:to-slate-500 transition-all duration-300 font-orbitron text-center">
                    <i class="bi bi-x-circle mr-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection