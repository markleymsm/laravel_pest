<?php

use App\Models\Product;

use function Pest\Laravel\get;

test('testing api of products it need to return our list of products')
  ->get('/api/products')
  ->assertOk()
  ->assertExactJson([
    ['title' => 'Produto 1'],
    ['title' => 'Produto 2'],
  ]);


it('should list products on database', function () {
  $product1 = Product::factory()->create();
  $product2 = Product::factory()->create();

  get('/api/products-db')
    ->assertOk()
    ->assertJson([
      ['title' => 'Produto 1'],
      ['title' => 'Produto 2'],
      ['title' => $product1->title],
      ['title' => $product2->title],
    ]);
});
