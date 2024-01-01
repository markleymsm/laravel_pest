<?php

use App\Models\Product;
use App\Models\User;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    expect($product->owner)->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should be always be str()->title()', function () {
    
    $product = Product::factory()->create(['title' => 'titulo']);

    expect($product)->title->toBe('Titulo');
});
