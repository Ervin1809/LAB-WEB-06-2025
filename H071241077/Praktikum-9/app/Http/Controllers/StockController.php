<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $selectedWarehouse = $request->get('warehouse_id');
        $warehouses = Warehouse::orderBy('name')->get();

        $query = DB::table('product_warehouse')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'warehouses.id as warehouse_id',
                'warehouses.name as warehouse_name',
                DB::raw('SUM(product_warehouse.quantity) as total')
            )
            ->groupBy(
                'product_warehouse.product_id',
                'product_warehouse.warehouse_id',
                'products.id',
                'products.name',
                'warehouses.id',
                'warehouses.name'
            );

        if ($selectedWarehouse) {
            $query->where('warehouses.id', $selectedWarehouse);
        }

        $items = $query->get();

        return view('stocks.index', compact('items', 'warehouses', 'selectedWarehouse'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    /**
     * Tambah atau Kurangi stok di satu gudang.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|not_in:0', // bisa positif (+) atau negatif (-)
        ]);

        $quantity = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($validated, $quantity) {
                // Lock baris yang relevan agar tidak race condition
                $existing = DB::table('product_warehouse')
                    ->where('product_id', $validated['product_id'])
                    ->where('warehouse_id', $validated['warehouse_id'])
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $newQty = $existing->quantity + $quantity;

                    // ✅ Validasi stok negatif
                    if ($newQty < 0) {
                        throw new \Exception('❌ Stok tidak boleh negatif! Jumlah stok saat ini: '.$existing->quantity);
                    }

                    DB::table('product_warehouse')
                        ->where('product_id', $validated['product_id'])
                        ->where('warehouse_id', $validated['warehouse_id'])
                        ->update(['quantity' => $newQty]);
                } else {
                    // Jika belum ada, pastikan tidak boleh langsung mengurangi stok
                    if ($quantity < 0) {
                        throw new \Exception('❌ Tidak bisa mengurangi stok karena produk ini belum memiliki stok di gudang!');
                    }

                    DB::table('product_warehouse')->insert([
                        'product_id' => $validated['product_id'],
                        'warehouse_id' => $validated['warehouse_id'],
                        'quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

            // Jika transaksi berhasil
            $action = $quantity > 0 ? 'Penambahan' : 'Pengurangan';

            return redirect()->route('stocks.index')->with('success', $action.' stok berhasil!');
        } catch (\Exception $e) {

            // Jika ada error (stok negatif, dll)
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }

    }
}
