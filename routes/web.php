<?php

use App\Jobs\ImportProductJob;
use App\Mail\SendingEmail;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Mail;
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
    request()->validate([
        'title' => ['required', 'max:255']
    ]);
    
    Product::query()
        ->create([
           'title' => request()->get('title'),
           'owner_id' => auth()->id()
        ]);

    auth()->user()->notify(
        new NewProductNotification()
    );

    return response()->json('', 201);
})->name('product.store');

Route::put('/products/{product}', function (Product $product) {
    $product->title = request()->get('title');
    $product->save();

    return response()->json('', 200);
})->name('product.update');

Route::delete('/products/{product}', function (Product $product) {
    $product->forceDelete();

    return response()->json('', 200);
})->name('product.destroy');

Route::delete('/products/{product}/soft-delete', function (Product $product) {
    $product->delete();

    return response()->json('', 200);
})->name('product.soft-delete');

Route::post('/import-products', function(){
    $data = request()->get('data');

    ImportProductJob::dispatch($data, auth()->id());
})->name('product.import');

Route::post('/sending-email/{user}', function(User $user){
    Mail::to($user)->send(new SendingEmail($user));
})->name('sending-email');
