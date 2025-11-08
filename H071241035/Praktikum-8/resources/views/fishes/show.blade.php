@extends('layouts.app')

@section('title', $fish->name . ' - Details')

@section('content')
<div x-data="{ modalOpen: false }" class="mx-auto max-w-4xl">
    <div class="rounded-xl border border-slate-700 bg-slate-800/60 backdrop-blur-sm shadow-xl shadow-cyan-500/10 overflow-hidden">
        {{-- Card Header with Gaming Aesthetic --}}
        <div class="border-b border-slate-700 bg-gradient-to-r from-slate-800/50 to-slate-900/50 p-6 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 to-purple-500/5"></div>
            <div class="relative flex items-center justify-between">
                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400 font-orbitron flex items-center space-x-3">
                    <i class="bi bi-water text-3xl"></i>
                    <span class="tracking-wider">{{ $fish->name }}</span>
                </h2>
                <div class="flex items-center space-x-3">
                    <span class="rounded-full px-4 py-2 text-lg font-bold text-white rarity-{{ strtolower($fish->rarity) }} {{ strtolower($fish->rarity) == 'secret' ? 'glow-secret' : 'glow-' . strtolower($fish->rarity) }} font-orbitron tracking-wide transition duration-300">{{ $fish->rarity }}</span>
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Basic Info Card --}}
                <div class="space-y-4 rounded-xl bg-slate-900/50 p-5 border border-slate-700/50 backdrop-blur-sm">
                    <div class="flex items-center space-x-2 border-b border-slate-700 pb-3">
                        <i class="bi bi-info-circle text-cyan-400"></i>
                        <h3 class="font-bold text-cyan-400 font-orbitron tracking-wide">BASIC INFORMATION</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                            <dt class="text-slate-400 font-orbitron">Fish ID:</dt>
                            <dd class="font-medium text-white font-mono">#{{ $fish->id }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                            <dt class="text-slate-400 font-orbitron">Created:</dt>
                            <dd class="font-medium text-white">{{ $fish->created_at->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-slate-400 font-orbitron">Last Updated:</dt>
                            <dd class="font-medium text-white">{{ $fish->updated_at->format('d M Y') }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Stats Card --}}
                <div class="space-y-4 rounded-xl bg-slate-900/50 p-5 border border-slate-700/50 backdrop-blur-sm">
                    <div class="flex items-center space-x-2 border-b border-slate-700 pb-3">
                        <i class="bi bi-bar-chart text-cyan-400"></i>
                        <h3 class="font-bold text-cyan-400 font-orbitron tracking-wide">STATISTICS</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                            <dt class="text-slate-400 font-orbitron">Weight Range:</dt>
                            <dd class="font-medium text-white">{{ $fish->weight_range }} </dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                            <dt class="text-slate-400 font-orbitron">Price/kg:</dt>
                            <dd class="font-medium text-white flex items-center">
                                <i class="bi bi-coin text-yellow-400 mr-1"></i>{{ $fish->formatted_price }} <span class="ml-1 text-xs text-cyan-400">coins</span>
                            </dd>
                        </div>
                        <div class="py-2">
                            <dt class="text-slate-400 font-orbitron mb-2 flex justify-between">
                                <span>Catch Rate:</span>
                                <span class="text-white">{{ $fish->catch_probability }}%</span>
                            </dt>
                            <div class="h-3 w-full rounded-full bg-slate-800 border border-slate-700 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-cyan-600 to-blue-500 flex items-center justify-end pr-2" style="width: {{ $fish->catch_probability }}%">
                                    <span class="text-xs text-white font-bold">{{ $fish->catch_probability }}%</span>
                                </div>
                            </div>
                        </div>
                    </dl>
                </div>

                @if($fish->description)
                <div class="md:col-span-2 rounded-xl bg-slate-900/50 p-5 border border-slate-700/50 backdrop-blur-sm">
                    <div class="flex items-center space-x-2 border-b border-slate-700 pb-3">
                        <i class="bi bi-card-text text-cyan-400"></i>
                        <h3 class="font-bold text-cyan-400 font-orbitron tracking-wide">DESCRIPTION</h3>
                    </div>
                    <p class="mt-3 text-base text-slate-300 italic font-light">"{{ $fish->description }}"</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Card Footer --}}
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 p-6 border-t border-slate-700 bg-slate-800/50 backdrop-blur-sm">
            <div class="flex space-x-3">
                <a href="{{ route('fishes.index') }}" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 text-slate-200 hover:from-slate-600 hover:to-slate-500 transition-all duration-300 font-orbitron">
                    <i class="bi bi-arrow-left-circle mr-2"></i> Back to List
                </a>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('fishes.edit', $fish) }}" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-yellow-600 to-yellow-500 text-white hover:from-yellow-500 hover:to-yellow-400 transition-all duration-300 font-orbitron">
                    <i class="bi bi-pencil mr-2"></i> Edit
                </a>
                <button @click="modalOpen = true" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-500 hover:to-red-400 transition-all duration-300 font-orbitron">
                    <i class="bi bi-trash mr-2"></i> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div x-show="modalOpen" x-cloak @click.away="modalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div class="w-full max-w-md rounded-xl border border-slate-700 bg-slate-800 p-6 backdrop-blur-md shadow-xl shadow-red-500/20">
            <div class="flex items-center space-x-3 mb-4">
                <i class="bi bi-exclamation-triangle-fill text-2xl text-red-500"></i>
                <h3 class="text-lg font-bold text-white font-orbitron">CONFIRM DELETION</h3>
            </div>
            <p class="text-sm text-slate-400">Are you sure you want to delete</p>
            <p class="mt-1 text-md font-bold text-white"><strong>"{{ $fish->name }}"</strong>?</p>
            <p class="mt-3 text-sm text-slate-400">This action cannot be undone and will permanently remove this fish from the database.</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button @click="modalOpen = false" type="button" class="px-5 py-2.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-200 transition duration-300 font-orbitron">Cancel</button>
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" @submit.prevent="modalOpen = false; $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white transition duration-300 font-orbitron">
                        Confirm Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection