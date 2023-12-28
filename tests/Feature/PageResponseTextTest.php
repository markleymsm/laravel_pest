<?php

use App\Models\Product;

use function Pest\Laravel\get;

it('should list product')
  ->get('/products')
  ->assertOk()
  ->assertSeeTextInOrder([
    'Product 1',
    'Product 2',
  ]);

it('should list product on database', function () {
  $product1 = Product::factory()->create();
  $product2 = Product::factory()->create();

  get('/products-db')
    ->assertOk()
    ->assertSeeTextInOrder([
      'Product 1',
      'Product 2',
      $product1->title,
      $product2->title,
    ]);
});
