<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', function () {
    return [
        ['title' => 'Produto 1',],
        ['title' => 'Produto 2',],
    ];
});

Route::get('/products-db', function () {
    $products = Product::all();
    $products->map(fn ($product) => ['title' => $product->title]);

    return array_merge([
        ['title' => 'Produto 1',],
        ['title' => 'Produto 2',],
    ], $products->toArray());
});
