<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id', // product_id diisi otomatis saat create via relasi
        'description',
        'weight',
        'size',
    ];

    /**
     * Mendapatkan produk induk dari detail ini.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}