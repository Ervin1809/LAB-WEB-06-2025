<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FishController extends Controller
{

    public function index(Request $request)
    {
        $rarity = $request->get('rarity'); 
        $search = $request->get('search'); 

        $fishes = Fish::query()
            ->searchByName($search) 
            ->filterByRarity(rarity: $rarity) 
            ->paginate(10)
            ->withQueryString();

        return view('fishes.index', [
            'fishes' => $fishes,
            'rarities' => Fish::RARITIES, 
            'currentRarity' => $rarity, 
            'currentSearch' => $search,
        ]);
    }

    public function create()
    {
        return view('fishes.create', [
            'rarities' => Fish::RARITIES 
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100', // 
            'rarity' => ['required', Rule::in(Fish::RARITIES)], // 
            'base_weight_min' => 'required|decimal:0,2|min:0', // 
            'base_weight_max' => 'required|decimal:0,2|gt:base_weight_min', // 
            'sell_price_per_kg' => 'required|integer|min:0', // 
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00', // 
            'description' => 'nullable|string', // 
        ];
        $messages = [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
        ];

        $validated = $request->validate($rules, $messages);

        Fish::create($validated);

        return redirect()->route('fishes.index')
                         ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', ['fish' => $fish]);
    }

    public function edit(Fish $fish)
    {
        return view('fishes.edit', [
            'fish' => $fish,
            'rarities' => Fish::RARITIES 
        ]);
    }

    public function update(Request $request, Fish $fish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => ['required', Rule::in(Fish::RARITIES)],
            'base_weight_min' => 'required|decimal:0,2|min:0',
            'base_weight_max' => 'required|decimal:0,2|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan berhasil diupdate!');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan berhasil dihapus.');
    }
}