<?php

use function Pest\Laravel\postJson;

test('product :: title should be required', function () {
  postJson(route('product.store'), ['title' => ''])
    ->assertInvalid(['title' => 'required']);
});
