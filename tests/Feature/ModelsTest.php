<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    expect($product->owner)->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should be always be str()->title()', function () {
    
    $product = Product::factory()->create(['title' => 'titulo']);

    expect($product)->title->toBe('Titulo');
});

test('model setmutator :: product code should be encrypted', function () {
    
    $product = Product::factory()->create(['code' => 'ahahahahahjaj']);

    assertTrue(Hash::isHashed($product->code));
});
