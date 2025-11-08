<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
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
        'description',
    ];

    public $timestamps = true;

    /** Filter berdasarkan rarity */
    public function scopeRarity($query, $rarity)
    {
        if (! empty($rarity)) {
            return $query->where('rarity', $rarity);
        }

        return $query;
    }

    /** Filter pencarian nama ikan */
    public function scopeSearch($query, $keyword)
    {
        if (! empty($keyword)) {
            return $query->where('name', 'LIKE', '%'.$keyword.'%');
        }

        return $query;
    }

    /** Accessor format data */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->sell_price_per_kg).'Coins';
    }

    public function getFormattedWeightAttribute()
    {
        return number_format($this->base_weight_min, 2).' kg - '.
        number_format($this->base_weight_max, 2).' kg';
    }

    public function getFormattedProbabilityAttribute()
    {
        return number_format($this->catch_probability, 2).'%';
    }
}
