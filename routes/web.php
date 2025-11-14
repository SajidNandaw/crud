<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// 🔥 ROUTE CUSTOM WAJIB DI ATAS RESOURCE
Route::get('/products/view-all', [ProductController::class, 'viewAll'])
    ->name('products.viewall'); // pakai huruf kecil semua

// CRUD Resource
Route::resource('products', ProductController::class);
