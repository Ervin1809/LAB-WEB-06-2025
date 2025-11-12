<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {
    public function index(){
        $products = Product::with('category')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }
    public function create(){
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }
    public function store(Request $r){
        $r->validate([
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'description'=>'nullable|string',
            'weight'=>'required|numeric|min:0',
            'size'=>'nullable|string|max:255'
        ]);
        DB::transaction(function() use($r){
            $p = Product::create($r->only('name','price','category_id'));
            ProductDetail::create([
                'product_id'=>$p->id,
                'description'=>$r->description,
                'weight'=>$r->weight,
                'size'=>$r->size
            ]);
        });
        return redirect()->route('products.index')->with('success','Produk dibuat.');
    }
    public function show($id){
        $product = Product::with(['category','detail','warehouses'])->findOrFail($id);
        return view('products.show', compact('product'));
    }
    public function edit($id){
        $product = Product::with('detail')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product','categories'));
    }
    public function update(Request $r, $id){
        $r->validate([
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'description'=>'nullable|string',
            'weight'=>'required|numeric|min:0',
            'size'=>'nullable|string|max:255'
        ]);
        DB::transaction(function() use($r,$id){
            $p = Product::findOrFail($id);
            $p->update($r->only('name','price','category_id'));
            $detail = $p->detail;
            if($detail){
                $detail->update(['description'=>$r->description,'weight'=>$r->weight,'size'=>$r->size]);
            } else {
                ProductDetail::create(['product_id'=>$p->id,'description'=>$r->description,'weight'=>$r->weight,'size'=>$r->size]);
            }
        });
        return redirect()->route('products.index')->with('success','Produk diperbarui.');
    }
    public function destroy($id){
        $p = Product::findOrFail($id);
        $p->delete();
        return redirect()->route('products.index')->with('success','Produk dihapus.');
    }
}
