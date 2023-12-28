<?php

it('should list product')
  ->get('/products')
  ->assertOk()
  ->assertSeeTextInOrder([
    'Product 1',
    'Product 2',
  ]);
