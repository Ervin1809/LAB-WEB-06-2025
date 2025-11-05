<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;

class FishController extends Controller
{
    public function index(Request $request){
        $rarity = $request->query('rarity');
        $search = $request->query('search');
        $sort = $request->query('sort', 'id');
        $dir  = $request->query('dir', 'asc');

        $query = Fish::query()
            ->search($search)
            ->rarity($rarity);

        if (in_array($sort, ['id','name','sell_price_per_kg','catch_probability'])) {
            $query->orderBy($sort, $dir);
        }

        $fishes = $query->paginate(10)->withQueryString();

        return view('fishes.index', [
            'fishes' => $fishes,
            'rarity' => $rarity,
            'search' => $search,
            'sort' => $sort,
            'dir' => $dir,
        ]);
    }


    public function create()
    {
        return view('fishes.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',

            // Berat tidak boleh 0, harus lebih dari 0
            'base_weight_min' => 'required|numeric|gt:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',

            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100',
            'description' => 'nullable|string',
        ], [
            'base_weight_min.gt' => 'Berat minimum harus lebih besar dari 0.',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.between' => 'Peluang tertangkap harus antara 0.01 dan 100.',
        ]);

        Fish::create($validated);

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $fish = Fish::findOrFail($id);
        return view('fishes.show', compact('fish'));
    }

    public function edit($id)
    {
        $fish = Fish::findOrFail($id);
        return view('fishes.edit', compact('fish'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',

            'base_weight_min' => 'required|numeric|gt:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',

            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100',
            'description' => 'nullable|string',
        ], [
            'base_weight_min.gt' => 'Berat minimum harus lebih besar dari 0.',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.between' => 'Peluang tertangkap harus antara 0.01 dan 100.',
        ]);

        $fish = Fish::findOrFail($id);
        $fish->update($validated);

        return redirect()->route('fishes.index', $fish->id)->with('success', 'Data ikan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $fish = Fish::findOrFail($id);
        $fish->delete();

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus.');
    }
}
