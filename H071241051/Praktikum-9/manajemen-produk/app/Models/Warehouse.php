<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
    ];

    public function products()
    {
        // Relasi N:M ke Product, melalui tabel 'product_warehouse'
        // 'withPivot' untuk mengambil data 'quantity'
        return $this->belongsToMany(Product::class, 'product_warehouse')
                    ->withPivot('quantity');
    }
}