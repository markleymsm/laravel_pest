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

// dataset(grupo de test) para validação dos campos do formulário de cadastro de produtos.
test('create product validations', function ($data, $errors) {
  postJson(route('product.store'), $data)
    ->assertInvalid($errors);
})->with([
  'title:required' => [['title' => ''], ['title' => 'required']],
  'title:max:255' => [['title' => str_repeat('*', 256)], ['title' => 'The title field must not be greater than 255 characters.']],
]);
