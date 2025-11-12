<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class); //N:1 relasi dengan Category
    }



    public function productDetail(): HasOne
    {
        return $this->hasOne(ProductDetail::class); //1:1 relasi dengan ProductDetail
    }



    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'products_warehouses') //N:M relasi dengan Warehouse
                    ->withPivot('quantity'); // Penting: Ambil kolom 'quantity' dari tabel pivot
    }
}