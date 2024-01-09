<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotification;

class CreateProductAction
{
    public function handle(string $title, User $user): void
    {

        Product::query()
            ->create([
                'title' => $title,
                'owner_id' => $user->id,
            ]);

        $user->notify(
            new NewProductNotification()

        );
    }
}
