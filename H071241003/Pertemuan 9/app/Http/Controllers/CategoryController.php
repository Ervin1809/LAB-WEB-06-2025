<?php

namespace App\Http\Controllers;

use App\Models\Category; // Ganti Kategori -> Category
use Illuminate\Http\Request;

class CategoryController extends Controller // Ganti nama class
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->keyword;

        $categories = Category::when($search, function ($query, $search) {
            // Ganti 'nama_kategori' -> 'name'
            return $query->where('name', 'like', "%{$search}%");
        })->get();

        // Ganti view 'pages.kategori.show' -> 'pages.categories.show'
        // Ganti variabel 'kategori' -> 'categories'
        return view('pages.categories.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ganti view 'pages.kategori.add' -> 'pages.categories.add'
        return view('pages.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ganti validasi
        $request->validate([
            'name' => 'required',
            'description' => 'nullable', // Deskripsi boleh kosong
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        // Ganti perintah create
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Ganti redirect '/kategori' -> '/categories'
        return redirect('/categories')->with('message', 'Berhasil Menambahkan Data Kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Di soal, show kategori tidak diminta, tapi kita isi saja
        $category = Category::findOrFail($id);
        return view('pages.categories.detail', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ganti Model Kategori -> Category
        $category = Category::findOrFail($id);

        // Ganti view 'pages.kategori.edit' -> 'pages.categories.edit'
        // Ganti variabel 'kategori' -> 'category'
        return view('pages.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ganti validasi
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        // Ganti perintah update
        Category::findOrFail($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Ganti redirect '/kategori' -> '/categories'
        return redirect('/categories')->with('message', 'Berhasil Mengubah Data Kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ganti Model Kategori -> Category
        Category::findOrFail($id)->delete();

        // Ganti redirect '/kategori' -> '/categories'
        return redirect('/categories')->with('message', 'Data Kategori Berhasil dihapus!!');
    }
}