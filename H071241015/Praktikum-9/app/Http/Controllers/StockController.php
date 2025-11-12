<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Kita akan gunakan Query Builder untuk pivot

class StockController extends Controller
{

    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $selectedWarehouse = null;
        $stocks = null;

        // Jika ada filter warehouse_id di URL
        if ($request->filled('warehouse_id')) {
            $selectedWarehouse = Warehouse::find($request->warehouse_id);
            if ($selectedWarehouse) {
                // 'products' dari relasi N:M sudah otomatis
                // membawa data 'quantity' dari pivot
                $stocks = $selectedWarehouse->products()->get();
            }
        }

        return view('stock.index', compact('warehouses', 'selectedWarehouse', 'stocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('stock.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0', // Kuantitas tidak boleh 0
        ]);

        $warehouse_id = $request->warehouse_id;
        $product_id = $request->product_id;
        $adjustment = (int) $request->quantity; // Misal: +10 atau -5

        // Dapatkan stok saat ini
        $currentStockPivot = DB::table('products_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->first();

        $currentStock = $currentStockPivot ? $currentStockPivot->quantity : 0;

        // Validasi penting: Cek jika stok akan menjadi minus
        if ($adjustment < 0 && abs($adjustment) > $currentStock) {
            return back()->withInput()
                         ->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $currentStock . '. Anda mencoba mengurangi ' . abs($adjustment) . '.');
        }

        $newStock = $currentStock + $adjustment;

        // Gunakan updateOrInsert untuk efisiensi
        // - Jika data (product_id, warehouse_id) sudah ada, UPDATE quantity
        // - Jika belum ada, INSERT data baru
        DB::table('products_warehouses')->updateOrInsert(
            [ // Kunci pencarian
                'warehouse_id' => $warehouse_id,
                'product_id' => $product_id
            ],
            [ // Data yang di-update atau di-insert
                'quantity' => $newStock
            ]
        );

        return redirect()->route('stock.index', ['warehouse_id' => $warehouse_id])
                         ->with('success', 'Stok produk berhasil diperbarui. Stok baru: ' . $newStock);
    }
}