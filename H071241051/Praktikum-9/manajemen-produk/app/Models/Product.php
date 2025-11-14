<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    /**
     * Mendapatkan kategori dari produk ini.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendapatkan detail dari produk ini.
     */
    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    /**
     * Mendapatkan gudang tempat produk ini disimpan.
     */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
                    ->withPivot('quantity');
    }
}