<?php

namespace App\Http\Controllers;

use App\Models\Fishes;
use Illuminate\Http\Request;

class FishesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        
        $query = Fishes::query();

        // Filter berdasarkan rarity
        if ($request->filled('rarity')) {
            $query->rarity($request->rarity);
        }

        // Search berdasarkan nama
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sorting
        if ($request->filled('sort')) {
            $sortField = $request->sort;
            $sortDirection = $request->get('direction', 'asc');
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $fishes = $query->paginate(10)->withQueryString();

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.create', compact('rarities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|min:0|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        Fishes::create($validated);

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil ditambahkan! 🎣');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fishes $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fishes $fish)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fishes $fish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|min:0|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')
            ->with('success', 'Data ikan berhasil diupdate! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fishes $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil dihapus! 🗑️');
    }
}