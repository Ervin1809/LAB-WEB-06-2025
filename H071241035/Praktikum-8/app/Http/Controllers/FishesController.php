<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishesController extends Controller
{

    public function index(Request $request)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        
        $query = Fish::query();

        // Filter rarity
        if ($request->filled('rarity')) {
            $query->rarity($request->rarity);
        }

        // Search nama
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
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


    public function create()
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.create', compact('rarities'));
    }

    //simpan data baru
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

        Fish::create($validated);

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil ditambahkan! 🎣');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    public function update(Request $request, Fish $fish)
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
    
    public function destroy(Fish $fish)
    {
        $fishName = $fish->name;
        $fish->delete();

        return redirect()->route('fishes.index')
                         ->with('success', "Fish '{$fishName}' has been successfully deleted.");
    }
}