<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;// Seperti Publisher di BAB 9 [cite: 416]
// Kita tidak butuh Author, tapi kita butuh Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib untuk transaction [cite: 419]

class ProductController extends Controller
{
    public function index() {
        // Ambil produk, beserta data relasi 'category' (1:N)
        // Eager Loading [cite: 424]
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create() {
        // Ambil data 'categories' untuk dropdown [cite: 430]
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request) {
        // Validasi gabungan dari product dan product_detail [cite: 435]
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|decimal:0,2|min:0', // Sesuai [cite: 655]
            'category_id' => 'nullable|exists:categories,id',
            // Validasi ProductDetail [cite: 656]
            'description' => 'nullable|string',
            'weight' => 'required|numeric|decimal:0,2|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        // Gunakan Transaction untuk memastikan 2 tabel (products, product_details)
        // berhasil tersimpan bersamaan [cite: 447]
        DB::transaction(function () use ($request) {
            // 1. Simpan ke tabel 'products'
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // 2. Simpan ke tabel 'product_details' menggunakan relasi [cite: 453]
            $product->detail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);

            // Catatan: Relasi N:M (stok) tidak di-handle di sini,
            // tapi di Manajemen Stok
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product) {
        // Sesuai permintaan Tugas 9 [cite: 673]
        // Load relasi 1:1 dan 1:N
        $product->load(['detail', 'category']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product) {
        // Load relasi 1:1 dan 1:N [cite: 469]
        $product->load(['detail', 'category']);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) {
         $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|decimal:0,2|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|decimal:0,2|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        // Gunakan Transaction [cite: 486]
        DB::transaction(function () use ($request, $product) {
            // 1. Update tabel 'products'
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // 2. Update atau Buat (jika belum ada) tabel 'product_details' [cite: 492]
            $product->detail()->updateOrCreate(
                ['product_id' => $product->id], // Cari berdasarkan ini
                [ // Update/Create dengan data ini
                    'description' => $request->description,
                    'weight' => $request->weight,
                    'size' => $request->size,
                ]
            );
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product) {
        // Gunakan Transaction [cite: 510]
        DB::transaction(function () use ($product) {
            // 1. Hapus relasi N:M (stok) [cite: 511]
            $product->warehouses()->detach(); 

            // 2. Hapus relasi 1:1 (detail) [cite: 512]
            // Ini akan otomatis ter-trigger oleh onDelete('cascade'),
            // tapi lebih aman ditulis manual
            $product->detail()->delete();

            // 3. Hapus data 'product'
            $product->delete(); // [cite: 513]
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}