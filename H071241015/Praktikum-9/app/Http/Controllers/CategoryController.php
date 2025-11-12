<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        // Muat produk yang terkait dengan kategori ini
        $category->load('products'); 
        return view('categories.show', compact('category'));
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        try {
            // Sesuai migration, onDelete('set null') akan dijalankan oleh DB
            $category->delete(); 
            return redirect()->route('categories.index')
                             ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangani jika ada error (misal: foreign key constraint lain)
            return redirect()->route('categories.index')
                             ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}