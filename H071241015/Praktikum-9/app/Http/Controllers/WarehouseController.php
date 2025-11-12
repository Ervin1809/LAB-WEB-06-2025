<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{

    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:warehouses,name|max:255',
            'location' => 'nullable|string',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil ditambahkan.');
    }


    public function show(Warehouse $warehouse)
    {
        // Muat produk dan data pivot (quantity)
        $warehouse->load('products'); 
        return view('warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|unique:warehouses,name,' . $warehouse->id . '|max:255',
            'location' => 'nullable|string',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Warehouse $warehouse)
    {
        try {
            // Sesuai migration, onDelete('cascade') akan menghapus
            // data di tabel pivot products_warehouses
            $warehouse->delete(); 
            return redirect()->route('warehouses.index')
                             ->with('success', 'Gudang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('warehouses.index')
                             ->with('error', 'Gagal menghapus gudang: ' . $e->getMessage());
        }
    }
}