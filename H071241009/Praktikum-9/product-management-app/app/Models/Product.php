<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass Assignment 
    protected $fillable = ['name', 'price', 'category_id'];

    // Relasi 1:N (Inverse) -> Satu Produk DIMILIKI OLEH Satu Kategori 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi 1:1 -> Satu Produk PUNYA Satu Detail 
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    // Relasi N:M -> Satu Produk ada di BANYAK Gudang
    public function warehouses()
    {
        // Nama pivot table, foreign key, foreign key
        return $this->belongsToMany(Warehouse::class, 'products_warehouses')
                    ->withPivot('quantity'); // agar bisa akses kolom 'quantity' 
    }
}