<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    // Menampilkan list stok 
    public function index(Request $request)
    {
        $warehouses = Warehouse::all(); // Untuk dropdown filter
        $selectedWarehouseId = $request->input('warehouse_id');

        $stockQuery = DB::table('products_warehouses')
            ->join('products', 'products_warehouses.product_id', '=', 'products.id')
            ->join('warehouses', 'products_warehouses.warehouse_id', '=', 'warehouses.id')
            ->select(
                'warehouses.name as warehouse_name', 
                'products.name as product_name', 
                'products_warehouses.quantity'
            );

        // Jika ada filter gudang 
        if ($selectedWarehouseId) {
            $stockQuery->where('warehouses.id', $selectedWarehouseId);
        }

        $stocks = $stockQuery->get();

        // Total (SUM) 
        $totalStock = $stockQuery->sum('products_warehouses.quantity');

        return view('stocks.index', compact('stocks', 'warehouses', 'selectedWarehouseId', 'totalStock'));
    }

    // Menampilkan form transfer 
    public function createTransfer()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    // Menyimpan data transfer 
    public function storeTransfer(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0', 
        ]);

        $warehouseId = $request->warehouse_id;
        $productId = $request->product_id;
        $quantityChange = (int) $request->quantity;

        // Gunakan Transaction untuk keamanan data
        DB::transaction(function () use ($warehouseId, $productId, $quantityChange) {

            // Ambil data pivot (stok) saat ini
            $currentStock = DB::table('products_warehouses')
                ->where('warehouse_id', $warehouseId)
                ->where('product_id', $productId)
                ->first();

            $currentQuantity = $currentStock ? $currentStock->quantity : 0;
            $newQuantity = $currentQuantity + $quantityChange;

            // Validasi agar stok tidak minus 
            if ($newQuantity < 0) {
                // Batalkan transaksi dan kirim error
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi. Stok saat ini: ' . $currentQuantity .
                                  '. Anda mencoba mengurangi ' . abs($quantityChange) . '.'
                ]);
            }

            // Update atau Insert (Upsert) data stok di pivot table
            DB::table('products_warehouses')->updateOrInsert(
                [ // Kondisi pencarian
                    'warehouse_id' => $warehouseId,
                    'product_id' => $productId
                ],
                [ // Data yang di-update atau di-insert
                    'quantity' => $newQuantity
                ]
            );
        });

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil ditransfer.');
    }
}