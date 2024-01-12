<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function Pest\Laravel\artisan;

it('should be abbe to guarantee that the user exists', function () {
    artisan(
        CreateProductCommand::class, 
        ['title' => 'Product 1', 'user' => 77]
    );
})->throws(ModelNotFoundException::class);
