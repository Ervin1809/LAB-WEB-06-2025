<?php

// app/Http/Controllers/FishController.php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Halaman Daftar Ikan (Index) [cite: 13]
     */
    public function index(Request $request)
    {
        $rarity = $request->query('rarity'); // Ambil filter rarity dari URL [cite: 16]
        $rarities = Fish::RARITIES; // Ambil daftar rarity untuk dropdown

        $fishes = Fish::query()
            ->filterRarity($rarity) // Menggunakan scope yang kita buat [cite: 46]
            ->paginate(10); // Tambahkan pagination [cite: 15]

        return view('fishes.index', compact('fishes', 'rarities', 'rarity'));
    }

    /**
     * Halaman Tambah Ikan Baru (Create) [cite: 18]
     */
    public function create()
    {
        $rarities = Fish::RARITIES; // [cite: 22]
        return view('fishes.create', compact('rarities'));
    }

    /**
     * Logika untuk menyimpan ikan baru (Store)
     */
    public function store(Request $request)
    {
        // Validasi [cite: 27]
        $validated = $request->validate([
            'name' => 'required|string|max:100', // [cite: 21, 29]
            'rarity' => 'required|in:' . implode(',', Fish::RARITIES), // [cite: 22, 29]
            'base_weight_min' => 'required|decimal:0,2', // [cite: 23, 29]
            // Berat maksimum harus lebih besar dari minimum [cite: 28]
            'base_weight_max' => 'required|decimal:0,2|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer', // [cite: 24, 29]
            // Peluang tangkap antara 0.01% - 100% [cite: 30]
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00', 
            'description' => 'nullable|string', // [cite: 26]
        ]);

        Fish::create($validated);

        return redirect()->route('fishes.index')
                         ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    /**
     * Halaman Lihat Detail Ikan (Show) [cite: 31]
     */
    public function show(Fish $fish)
    {
        // $fish sudah otomatis di-inject oleh Laravel (Route Model Binding)
        return view('fishes.show', compact('fish')); // [cite: 32]
    }

    /**
     * Halaman Edit Ikan (Edit) [cite: 33]
     */
    public function edit(Fish $fish)
    {
        $rarities = Fish::RARITIES;
        // Data sudah terisi otomatis karena kita passing $fish 
        return view('fishes.edit', compact('fish', 'rarities')); 
    }

    /**
     * Logika untuk update ikan (Update)
     */
    public function update(Request $request, Fish $fish)
    {
        // Validasi sama seperti create 
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:' . implode(',', Fish::RARITIES),
            'base_weight_min' => 'required|decimal:0,2',
            'base_weight_max' => 'required|decimal:0,2|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan berhasil diperbarui!');
    }

    /**
     * Logika Hapus Ikan (Delete/Destroy) [cite: 35]
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        
        // Konfirmasi akan ditangani di sisi front-end (JavaScript) [cite: 36]
        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan berhasil dihapus.');
    }
}