<?php

use function Pest\Laravel\postJson;

test('product :: title should be required', function () {
  postJson(route('product.store'), ['title' => ''])
    ->assertInvalid(['title' => 'required']);
});

test('product :: title should have a max of 255 characters', function () {
  postJson(route('product.store'), ['title' => str_repeat('*', 256)])
    ->assertInvalid(['title' => trans('validation.max.string', ['attribute' => 'title', 'max' => 255])]);
});


