<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    // Kita arahkan halaman utama langsung ke list kategori
    return redirect()->route('categories.index');
});

// Rute Kategori
Route::resource('categories', CategoryController::class);

// Rute Warehouse (Gudang)
// 'except' => ['show'] berarti kita tidak membuat rute 'show'
Route::resource('warehouses', WarehouseController::class)->except(['show']);

// Rute Produk
Route::resource('products', ProductController::class);

// Rute Manajemen Stok
Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::get('stock/transfer', [StockController::class, 'createTransfer'])->name('stock.transfer.create');
Route::post('stock/transfer', [StockController::class, 'storeTransfer'])->name('stock.transfer.store');