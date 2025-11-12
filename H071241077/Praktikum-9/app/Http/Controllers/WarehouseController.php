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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);
        try {
            Warehouse::create($data);

            return redirect()->route('warehouses.index')->with('success', 'Gudang dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan gudang.']);
        }
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);
        try {
            $warehouse->update($data);

            return redirect()->route('warehouses.index')->with('success', 'Gudang diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui gudang.']);
        }
    }

    public function destroy(Warehouse $warehouse)
    {
        try {
            $warehouse->delete();

            return redirect()->route('warehouses.index')->with('success', 'Gudang dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus gudang.']);
        }
    }
}
