<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Tampilkan daftar ikan (Index)
     */
    public function index(Request $request)
    {
        $rarity = $request->get('rarity');
        $search = $request->get('search');
        $sortBy = $request->get('sort_by');
        $sortDir = $request->get('dir', 'asc');

        $query = Fish::query()
            ->rarity($rarity)
            ->search($search);

        // Logika sorting
        if (! empty($sortBy)) {
            switch ($sortBy) {
                case 'name':
                    $query->orderBy('name', $sortDir);
                    break;
                case 'rarity':
                    $query->orderByRaw("CASE 
                        WHEN rarity = 'Common' THEN 1
                        WHEN rarity = 'Uncommon' THEN 2
                        WHEN rarity = 'Rare' THEN 3
                        WHEN rarity = 'Epic' THEN 4
                        WHEN rarity = 'Legendary' THEN 5
                        WHEN rarity = 'Mythic' THEN 6
                        WHEN rarity = 'Secret' THEN 7
                        ELSE 8
                    END ".($sortDir === 'desc' ? 'DESC' : 'ASC'));
                    break;
                case 'price':
                    $query->orderBy('sell_price_per_kg', $sortDir);
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $fishes = $query->paginate(10)->appends(request()->query());

        return view('fishes.index', compact('fishes', 'rarity', 'search', 'sortBy', 'sortDir'));
    }

    /**
     * Form tambah ikan baru (Create)
     */
    public function create()
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

        return view('fishes.create', compact('rarities'));
    }

    /**
     * Simpan ikan baru ke database (Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|between:0.01,100.00',
            'description' => 'nullable',
        ]);

        // Fish::create($request->all());
        Fish::create($request->all());

        // $fish = Fish::findOrFail($id);

        // $fish->update($request->all());

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil ditambahkan!');
    }

    /**
     * Detail ikan (Show)
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Form edit ikan (Edit)
     */
    public function edit(Fish $fish)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

        return view('fishes.edit', compact('fish', 'rarities'));
    }

    /**
     * Update data ikan (Update)
     */
    public function update(Request $request, Fish $fish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rarity' => 'nullable|string|max:255',
            'base_weight_min' => 'nullable|numeric|min:0',
            'base_weight_max' => 'nullable|numeric|min:0|gte:base_weight_min',
            'sell_price_per_kg' => 'nullable|numeric|min:0',
            'catch_probability' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
        ]);

        $fish->update($request->all());

        // Jika dari halaman detail, redirect kembali ke detail
        if ($request->redirect_to === 'show') {
            return redirect()
                ->route('fishes.show', $fish)
                ->with('success', 'Fish updated successfully!');
        }

        // Default redirect ke index
        return redirect()
            ->route('fishes.index')
            ->with('success', 'Fish updated successfully!');
    }

    /**
     * Hapus ikan (Destroy)
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus!');
    }
}
