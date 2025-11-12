<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Penting untuk Transaction

class ProductController extends Controller
{

    public function index()
    {
        // 'with('category')' untuk Eager Loading, menghindari N+1 query
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi untuk tabel products
            'name' => 'required|string|unique:products,name|max:255',
            'price' => 'required|numeric|min:0|max:9999999999999.99', // Sesuai decimal(15,2)
            'category_id' => 'nullable|exists:categories,id',
            
            // Validasi untuk tabel product_details
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:999999.99', // Sesuai decimal(8,2)
            'size' => 'nullable|string|max:255',
        ]);

        // Mulai database transaction
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel 'products'
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // 2. Simpan ke tabel 'product_details' menggunakan relasi
            $product->productDetail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);

            // Jika semua berhasil, commit transaction
            DB::commit();

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Jika terjadi error, rollback semua perubahan
            DB::rollBack();
            return back()->withInput()
                         ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        // Muat semua relasi: kategori, detail, dan gudang (stok)
        $product->load('category', 'productDetail', 'warehouses');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Muat relasi productDetail agar datanya bisa ditampilkan di form
        $product->load('productDetail');
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Mengupdate data produk di database (tabel products & product_details).
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|unique:products,name,' . $product->id . '|max:255',
            'price' => 'required|numeric|min:0|max:9999999999999.99',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:999999.99',
            'size' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update tabel 'products'
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // 2. Update tabel 'product_details'
            // Gunakan updateOrCreate untuk keamanan jika detailnya (jarang) belum ada
            $product->productDetail()->updateOrCreate(
                ['product_id' => $product->id], // Kunci pencarian
                [ // Data untuk di-update
                    'description' => $request->description,
                    'weight' => $request->weight,
                    'size' => $request->size,
                ]
            );

            DB::commit();

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                         ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Sesuai migration, onDelete('cascade') akan otomatis menghapus
            // data di 'product_details' dan 'products_warehouses'
            $product->delete();
            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                             ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}