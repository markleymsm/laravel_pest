<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
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

it('should be able to create a product', function () {
    Notification::fake();

    $user = User::factory()->create();

    (new CreateProductAction())->handle('Product 1', $user);

    assertDatabaseCount('products', 1);
    assertDatabaseHas('products', [
        'title' => 'Product 1',
        'owner_id' => $user->id,
    ]);

    Notification::assertSentTo([$user], NewProductNotification::class);
});