<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    /**
     * Memberitahu model untuk menggunakan tabel 'fishes'
     * Ini adalah solusi untuk error kamu.
     */
    protected $table = 'fishes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];
}