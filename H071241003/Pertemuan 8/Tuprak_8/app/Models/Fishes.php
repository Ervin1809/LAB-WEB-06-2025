<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fishes extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description'
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2',
        'sell_price_per_kg' => 'integer',
    ];

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return number_format($this->sell_price_per_kg, 0, ',', '.');
    }

    // Accessor untuk format berat
    public function getWeightRangeAttribute()
    {
        return number_format($this->base_weight_min, 2) . ' - ' . number_format($this->base_weight_max, 2) . ' kg';
    }

    // Scope untuk filter berdasarkan rarity
    public function scopeRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    // Scope untuk search berdasarkan nama
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }

    // Badge color untuk rarity
    public function getRarityColorAttribute()
    {
        return match($this->rarity) {
            'Common' => 'secondary',
            'Uncommon' => 'success',
            'Rare' => 'primary',
            'Epic' => 'purple',
            'Legendary' => 'warning',
            'Mythic' => 'danger',
            'Secret' => 'dark',
            default => 'secondary'
        };
    }
}