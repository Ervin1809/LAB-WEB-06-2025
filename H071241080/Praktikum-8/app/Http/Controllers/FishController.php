<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 

class FishController extends Controller
{
    /**
     * Display a listing of the resource (Index).
     * Menerapkan Filter, Search, dan Sorting (termasuk custom sort Rarity).
     */
    public function index(Request $request)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        
        $query = Fish::query();

        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sortColumn = $request->get('sort', 'name'); 
        $sortDirection = $request->get('direction', 'asc'); 

        $allowedSorts = ['name', 'sell_price_per_kg', 'catch_probability', 'id', 'rarity', 'base_weight_min', 'base_weight_max']; 

        if (!in_array($sortColumn, $allowedSorts)) {
            $sortColumn = 'name'; 
        }

        // Sort untuk rarity dgn field
        if ($sortColumn === 'rarity') {
            $rarityOrder = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
            
            // MySQL FIELD()
            $query->orderByRaw("FIELD(rarity, '" . implode("','", $rarityOrder) . "') " . $sortDirection);
        } else {
            $query->orderBy($sortColumn, $sortDirection);
        }

        $fishes = $query->paginate(10)->withQueryString(); 

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    /**
     * Show the form for creating a new resource (Create).
     */
    public function create()
    {
        return view('fishes.create');
    }

    /**
     * Store a newly created resource in storage (Store).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string|max:100|unique:fishes,name',
            'rarity'            => ['required', Rule::in(['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'])],
            'base_weight_min'   => 'required|numeric|min:0.01',
            'base_weight_max'   => 'required|numeric|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|between:0.01,100.00', 
            'description'       => 'nullable|string',
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.between' => 'Peluang tangkap harus antara 0.01% dan 100.00%.',
        ]);

        Fish::create($validatedData);

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan **' . $request->name . '** berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (Show).
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource (Edit).
     */
    public function edit(Fish $fish)
    {
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage (Update).
     */
    public function update(Request $request, Fish $fish)
    {
        $validatedData = $request->validate([
            'name'              => ['required','string','max:100', Rule::unique('fishes')->ignore($fish->id), ],
            'rarity'            => ['required', Rule::in(['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'])],
            'base_weight_min'   => 'required|numeric|min:0.01',
            'base_weight_max'   => 'required|numeric|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|between:0.01,100.00', 
            'description'       => 'nullable|string',
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.between' => 'Peluang tangkap harus antara 0.01% dan 100.00%.',
        ]);

        $fish->update($validatedData);

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan "' . $fish->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (Destroy).
     */
    public function destroy(Fish $fish)
    {
        $fishName = $fish->name;

        $fish->delete();

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan "' . $fishName . '" berhasil dihapus.');
    }
}
