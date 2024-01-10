<?php

use App\Http\Middleware\SecureRouteMiddleware;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\mock;

it('should block a request if the user does not have the following email: email@email.com', function () {
    $userWrong = User::factory()->create(['email' => 'email@sameemail.com']);
    $userRight = User::factory()->create(['email' => 'email@email.com']);

    actingAs($userWrong);
    get(route('secure-route'))->assertForbidden();

    actingAs($userRight);
    get(route('secure-route'))->assertOk();
});

test('check if is being called', function () {
    mock(SecureRouteMiddleware::class)
        ->shouldReceive('handle')
        ->atLeast()
        ->once();

    get(route('secure-route'));
});
