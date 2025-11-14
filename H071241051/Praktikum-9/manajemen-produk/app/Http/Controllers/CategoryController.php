<?php

namespace App\Http\Controllers;

use App\Models\Category; // <-- Pastikan Modelnya ada
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan list kategori (Index)
     */
    public function index()
    {
        // Ambil data dari database
        $categories = Category::orderBy('created_at', 'desc')->get();
        // Kirim data ke view
        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru (Create)
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Buat data baru di database
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kategori (Show)
     */
    public function show(Category $category)
    {
        // $category sudah otomatis diambil by ID
        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan form untuk mengedit kategori (Edit)
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update data kategori di database
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update data di database
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}