<?php
namespace App\Http\Controllers;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller {
    public function index(){
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }
    public function create(){ return view('warehouses.create'); }
    public function store(Request $r){
        $r->validate(['name'=>'required|string|max:255','location'=>'nullable|string']);
        Warehouse::create($r->only('name','location'));
        return redirect()->route('warehouses.index')->with('success','Gudang dibuat.');
    }
    public function edit($id){
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouses.edit', compact('warehouse'));
    }
    public function update(Request $r, $id){
        $r->validate(['name'=>'required|string|max:255','location'=>'nullable|string']);
        $w = Warehouse::findOrFail($id);
        $w->update($r->only('name','location'));
        return redirect()->route('warehouses.index')->with('success','Gudang diperbarui.');
    }
    public function destroy($id){
        $w = Warehouse::findOrFail($id);
        $w->delete();
        return redirect()->route('warehouses.index')->with('success','Gudang dihapus.');
    }
    public function show($id)
    {
        $warehouse = Warehouse::with(['products' => function($q) {
            $q->with('category');
        }])->findOrFail($id);

        return view('warehouses.show', compact('warehouse'));
    }

}
