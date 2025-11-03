<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishesController;

Route::get('/', function () {
    return redirect()->route('fishes.index');
});

Route::resource('fishes', FishesController::class)->parameters([
    'fishes' => 'fish'
]);