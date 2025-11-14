<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Menampilkan list warehouse (Index)
     */
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Menampilkan form untuk membuat warehouse baru (Create)
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Menyimpan warehouse baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu warehouse (Show)
     */
    public function show(Warehouse $warehouse)
    {
        // Sesuai PDF, 'show' tidak diminta, tapi kita bisa buat jika perlu.
        // Untuk saat ini, kita redirect ke index.
        return redirect()->route('warehouses.index');
    }

    /**
     * Menampilkan form untuk mengedit warehouse (Edit)
     */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    /**
     * Update data warehouse di database
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil diperbarui.');
    }

    /**
     * Menghapus warehouse dari database
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        
        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil dihapus.');
    }
}