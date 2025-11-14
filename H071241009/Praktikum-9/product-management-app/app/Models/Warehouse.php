<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    // Mass Assignment 
    protected $fillable = ['name', 'location'];

    // Relasi N:M -> Satu Gudang punya BANYAK Produk 
    public function products()
    {
        // Nama pivot table, foreign key, foreign key
        return $this->belongsToMany(Product::class, 'products_warehouses')
                    ->withPivot('quantity'); // agar bisa akses kolom 'quantity' 
    }
}