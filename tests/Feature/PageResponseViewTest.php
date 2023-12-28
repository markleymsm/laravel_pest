<?php

it('should be route products is use the view products')
  ->get('/products')
  ->assertViewIs('products');


test(' the route products is passing a list of products for the view products')
  ->get('/products-db')
  ->assertViewIs('products')
  ->assertViewHas('products');
