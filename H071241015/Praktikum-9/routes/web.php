<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('categories', CategoryController::class);

Route::resource('warehouses', WarehouseController::class);

Route::resource('products', ProductController::class);

Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::get('stock/transfer', [StockController::class, 'create'])->name('stock.transfer.create');
Route::post('stock/transfer', [StockController::class, 'store'])->name('stock.transfer.store');