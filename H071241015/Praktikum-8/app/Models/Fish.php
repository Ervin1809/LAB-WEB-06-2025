<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Import Builder

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    public const RARITIES = [
        'Common',
        'Uncommon',
        'Rare',
        'Epic',
        'Legendary',
        'Mythic',
        'Secret'
    ];

    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2',
    ];

    public function scopeFilterByRarity(Builder $query, ?string $rarity): Builder
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    public function scopeSearchByName(Builder $query, ?string $search): Builder
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }
}