<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(){
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }
    public function create(){ return view('categories.create'); }
    public function store(Request $r){
        $r->validate(['name'=>'required|string|max:255','description'=>'nullable|string']);
        Category::create($r->only('name','description'));
        return redirect()->route('categories.index')->with('success','Kategori dibuat.');
    }
    public function show($id){
        $category = Category::with('products')->findOrFail($id);
        return view('categories.show', compact('category'));
    }
    public function edit($id){
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function update(Request $r, $id){
        $r->validate(['name'=>'required|string|max:255','description'=>'nullable|string']);
        $cat = Category::findOrFail($id);
        $cat->update($r->only('name','description'));
        return redirect()->route('categories.index')->with('success','Kategori diperbarui.');
    }
    public function destroy($id){
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect()->route('categories.index')->with('success','Kategori dihapus.');
    }
}
