<?php

use App\Jobs\ImportProductJob;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be dispatch a job to the queue', function () {
    Queue::fake();
    $user = User::factory()->create();
    actingAs($user);
    
    postJson(route('product.import'), [
        'data' => [
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
            ['title' => 'Product 3'],
        ]
    ]);

    Queue::assertPushed(ImportProductJob::class);
});

it('should import products', function () {
    $user = User::factory()->create();
    $data = [
        ['title' => 'Product 1'],
        ['title' => 'Product 2'],
        ['title' => 'Product 3'],
    ];

    (new ImportProductJob($data, $user->id))->handle();

    assertDatabaseCount('products', 3);
    assertDatabaseHas('products', ['title' => 'Product 1']);
    assertDatabaseHas('products', ['title' => 'Product 2']);
    assertDatabaseHas('products', ['title' => 'Product 3']);
});
