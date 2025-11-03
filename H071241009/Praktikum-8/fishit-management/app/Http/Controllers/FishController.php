<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Http\Requests\StoreFishRequest; // <-- Gunakan Form Request kita
use Illuminate\Http\Request; // <-- Kita masih butuh ini untuk index

class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
            // 1. INI BAGIAN YANG PENTING (YANG MUNGKIN HILANG)
            // Kita harus mulai query builder-nya di sini
            $query = Fish::query();

            // 2. Ini adalah logika untuk filter rarity (biarkan saja)
            if ($request->filled('rarity')) {
                $query->where('rarity', $request->rarity);
            }

            // 3. Ini adalah baris yang sudah kamu ubah (dan sekarang akan berfungsi)
            // $query sekarang sudah terdefinisi dari baris di atas
            $fishes = $query->orderBy('id', 'ASC')->paginate(10);

            return view('fishes.index', compact('fishes'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fishes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Ganti 'Request' menjadi 'StoreFishRequest'
    public function store(StoreFishRequest $request)
    {
        // Validasi sudah otomatis dijalankan oleh StoreFishRequest
        Fish::create($request->validated());

        return redirect()->route('fishes.index')
                         ->with('success', 'Ikan baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish)
    {
        // Route model binding otomatis mencari $fish berdasarkan ID
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fish $fish)
    {
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Ganti 'Request' menjadi 'StoreFishRequest'
    public function update(StoreFishRequest $request, Fish $fish)
    {
        $fish->update($request->validated());

        return redirect()->route('fishes.index')
                         ->with('success', 'Data ikan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
                         ->with('success', 'Ikan berhasil dihapus.');
    }
}