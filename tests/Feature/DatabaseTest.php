<?php

use App\Models\Product;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;
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
	$product = Product::factory()->create(['title' => 'Titulo qualquer']);

	putJson(
		route('product.update', $product),
		['title' => 'atualizando o titulo']
	)->assertOk();

	assertDatabaseHas('products', [
		'id' => $product->id,
		'title' => 'atualizando o titulo'
	]);

	// é uma outra forma de fazer a verificação, 
	// nesse caso, ele recarrega a variavel em que foi criado o Model, passando o novo valor para ela,
	// e verifica se o novo valor é igual ao que foi passado no putJson, 
	// se sim, ele continua o teste, se não, ele para o teste e retorna um erro.
	expect($product)
		->refresh()
		->title
		->toBe('atualizando o titulo');

	// outra forma de verificar, é que o valor esperado seja igual ao valor do model atualizado
	assertSame('atualizando o titulo', $product->title);

	assertDatabaseCount('products', 1);
});

it('should be able to delete a product', function () {
	$product = Product::factory()->create(['title' => 'Titulo qualquer']);

	deleteJson(route('product.destroy', $product))->assertOk();

	assertDatabaseMissing('products', [
		'id' => $product->id,
	]);

	assertDatabaseCount('products', 0);
});

it('should be able to list all products', function () {
	//expect()->
})->todo();
