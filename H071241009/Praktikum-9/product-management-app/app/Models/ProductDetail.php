<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    // Mass Assignment 
    protected $fillable = ['product_id', 'description', 'weight', 'size'];

    // Relasi 1:1 (Inverse) -> Satu Detail DIMILIKI OLEH Satu Produk 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}