<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Menampilkan list stok (Index)
     * Memerlukan filter gudang
     */
    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $selectedWarehouseId = $request->query('warehouse_id');
        
        $warehouse = null;
        if ($selectedWarehouseId) {
            // Eager load relasi products dengan pivot 'quantity'
            $warehouse = Warehouse::with('products')->find($selectedWarehouseId);
        }

        return view('stock.index', compact('warehouses', 'warehouse', 'selectedWarehouseId'));
    }

    /**
     * Menampilkan form untuk transfer stok
     */
    public function createTransfer()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('stock.create_transfer', compact('warehouses', 'products'));
    }

    /**
     * Menyimpan data transfer (penambahan/pengurangan stok)
     */
    public function storeTransfer(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0', // tidak boleh 0
        ]);

        $warehouse = Warehouse::find($request->warehouse_id);
        $product = Product::find($request->product_id);
        $amount = (int) $request->quantity;

        // 2. Ambil stok saat ini
        // Cek relasi pivot, jika tidak ada, stok = 0
        $pivot = $product->warehouses()->where('warehouse_id', $warehouse->id)->first();
        $currentStock = $pivot ? $pivot->pivot->quantity : 0;

        // 3. Hitung stok baru
        $newStock = $currentStock + $amount;

        // 4. Validasi stok minus
        if ($newStock < 0) {
            return back()->with('error', 'Stok tidak boleh minus. Stok saat ini: ' . $currentStock)
                         ->withInput();
        }

        // 5. Simpan ke pivot table
        // 'syncWithoutDetaching' akan update pivot jika ada, atau create jika belum ada
        $product->warehouses()->syncWithoutDetaching([
            $warehouse->id => ['quantity' => $newStock]
        ]);

        return redirect()->route('stock.index', ['warehouse_id' => $warehouse->id])
                         ->with('success', 'Stok berhasil diperbarui.');
    }
}