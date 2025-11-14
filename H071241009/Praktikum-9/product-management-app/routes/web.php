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

Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('/stocks/transfer', [StockController::class, 'createTransfer'])->name('stocks.transfer.create');
Route::post('/stocks/transfer', [StockController::class, 'storeTransfer'])->name('stocks.transfer.store');