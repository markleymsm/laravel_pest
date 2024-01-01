<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/403', function () {
    abort_if(true, 403);
});

Route::get('/products', function () {
    return view('products');
});

Route::get('/products-db', function () {
    return view('products', [
        'products' => Product::all()
    ]);
});


Route::post('/products', function () {
    Product::query()->create(request()->only('title'));

    return response()->json('', 201);
})->name('product.store');

Route::put('/products/{product}', function (Product $product) {
    $product->title = request()->get('title');
    $product->save();

    return response()->json('', 200);
})->name('product.update');
