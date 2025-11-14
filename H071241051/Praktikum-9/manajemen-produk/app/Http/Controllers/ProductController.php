<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Penting untuk transaction

class ProductController extends Controller
{
    /**
     * Menampilkan list produk (Index)
     */
    public function index()
    {
        // Eager loading relasi category
        $products = Product::with('category')->orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru (Create)
     */
    public function create()
    {
        $categories = Category::all(); // Untuk dropdown
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database (Products & ProductDetails)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            // Atribut dari ProductDetail
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        // Gunakan Transaction untuk memastikan kedua data (product & detail) berhasil disimpan
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

            DB::commit(); // Sukses, simpan permanen

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil ditambahkan.');
                             
        } catch (\Exception $e) {
            DB::rollBack(); // Gagal, batalkan semua
            return back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Menampilkan detail satu produk (Show)
     */
    public function show(Product $product)
    {
        // Eager load relasi 'category' dan 'productDetail'
        $product->load('category', 'productDetail');
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk (Edit)
     */
    public function edit(Product $product)
    {
        // Load relasi productDetail agar bisa diakses di form
        $product->load('productDetail');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk di database
     */
    public function update(Request $request, Product $product)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
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
            // Gunakan updateOrCreate agar jika detail belum ada, akan dibuat
            $product->productDetail()->updateOrCreate(
                ['product_id' => $product->id], // Kunci pencarian
                [ // Data yang di-update
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
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Menghapus produk (dan product_details otomatis terhapus karena 'cascade')
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}