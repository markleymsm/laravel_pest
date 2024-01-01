<?php

use App\Models\Product;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertTrue;

it('should be able to create a product', function () {

	postJson(
		route('product.store'),
		['title' => 'titulo qualquer']
	)->assertCreated();


	// é passado a tabela e um array com o nome da coluna e o valor que quero verificar
	assertDatabaseHas('products', ['title' => 'titulo qualquer']);

	// essa verifica é mais detalhado, mas é como o assertDatabaseHas é feito por de baixo dos panos
	assertTrue(Product::query()->where('title', '=', 'titulo qualquer')->exists());

	// é passado o nome da tabela e o se houve alguma alteração na tabela
	assertDatabaseCount('products', 1);
});

it('should be able to update a product', function () {
	//expect()->
})->todo();

it('should be able to delete a product', function () {
	//expect()->
})->todo();

it('should be able to list all products', function () {
	//expect()->
})->todo();
