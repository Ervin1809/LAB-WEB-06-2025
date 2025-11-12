<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'] ?? null,
            ]);
            ProductDetail::create([
                'product_id' => $product->id,
                'description' => $validated['description'] ?? null,
                'weight' => $validated['weight'],
                'size' => $validated['size'] ?? null,
            ]);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan produk.']);
        }
    }

    public function show(Product $product)
    {
        $product->load('category', 'detail', 'warehouses');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('detail');

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'] ?? null,
            ]);
            if ($product->detail) {
                $product->detail->update([
                    'description' => $validated['description'] ?? null,
                    'weight' => $validated['weight'],
                    'size' => $validated['size'] ?? null,
                ]);
            } else {
                ProductDetail::create([
                    'product_id' => $product->id,
                    'description' => $validated['description'] ?? null,
                    'weight' => $validated['weight'],
                    'size' => $validated['size'] ?? null,
                ]);
            }
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui produk.']);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Produk dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus produk.']);
        }
    }
}
