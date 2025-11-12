<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_warehouses') // N:M relasi dengan Product
                    ->withPivot('quantity'); // Penting: Ambil kolom 'quantity' dari tabel pivot
    }
}