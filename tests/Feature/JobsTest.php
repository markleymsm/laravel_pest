<?php

use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\postJson;

it('should be dispatch a job to the queue', function () {
    Queue::fake();

    postJson(route('product.import'), [
        'data' => [
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
            ['title' => 'Product 3'],
        ]
    ]);

    Queue::assertPushed(ImportProductJob::class);
});
