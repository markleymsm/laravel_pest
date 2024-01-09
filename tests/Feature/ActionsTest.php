<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should call the action to create a product', function () {
    Notification::fake();

    // assert
    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()
        ->once();

    // arrange
    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);
    // act

    postJson(route('product.store'), ['title' => $title]);
});
