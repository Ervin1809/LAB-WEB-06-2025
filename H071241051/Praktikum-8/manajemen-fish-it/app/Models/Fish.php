<?php

// app/Models/Fish.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    /**
     * Daftar 7 tingkat rarity untuk dropdown [cite: 10, 22]
     */
    public const RARITIES = [
        'Common', 
        'Uncommon', 
        'Rare', 
        'Epic', 
        'Legendary', 
        'Mythic', 
        'Secret'
    ];

    /**
     * Atribut yang dapat diisi secara massal.
     * Ini penting untuk fitur Create [cite: 18] dan Update [cite: 33]
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

    /**
     * (Opsional, tapi sangat direkomendasikan)
     * Scope untuk filter rarity [cite: 16, 46]
     */
    public function scopeFilterRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }
}