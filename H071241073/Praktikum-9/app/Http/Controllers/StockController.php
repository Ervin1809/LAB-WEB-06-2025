<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $warehouse_id = $request->query('warehouse_id');

        $query = ProductWarehouse::with(['product', 'warehouse']);
        if ($warehouse_id) {
            $query->where('warehouse_id', $warehouse_id);
        }

        $stocks = $query->paginate(10);

        return view('stocks.index', compact('stocks', 'warehouses', 'warehouse_id'));
    }


    public function showTransferForm()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $productWarehouse = ProductWarehouse::firstOrCreate(
                    [
                        'warehouse_id' => $validated['warehouse_id'],
                        'product_id'   => $validated['product_id'],
                    ],
                    ['quantity' => 0]
                );

                $newQuantity = $productWarehouse->quantity + (int) $validated['quantity'];

                if ($newQuantity < 0) {
                    throw new \Exception('Operasi ditolak: stok tidak boleh negatif.');
                }

                $productWarehouse->update(['quantity' => $newQuantity]);
            });

            return redirect()->back()->with('success', 'Transfer stok berhasil.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
