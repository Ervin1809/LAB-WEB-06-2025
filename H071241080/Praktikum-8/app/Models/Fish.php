<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fishes';
    
    protected $fillable = [
        'name', 'rarity', 'base_weight_min', 'base_weight_max', 
        'sell_price_per_kg', 'catch_probability', 'description'
    ];
}
