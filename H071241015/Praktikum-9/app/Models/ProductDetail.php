<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    use HasFactory;


    protected $fillable = [
        'description',
        'weight',
        'size',
        // 'product_id' TIDAK dimasukkan di sini,
        // karena akan diisi melalui relasi ($product->productDetail()->create())
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class); //1:1 relasi dengan Product
    }
}