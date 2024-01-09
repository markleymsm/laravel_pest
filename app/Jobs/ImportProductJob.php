<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected readonly array $data,
        protected readonly string $ownerId,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $data) {
            Product::query()->create([
                'title' => $data['title'],
                'owner_id' => $this->ownerId,
            ]);
        }
    }
}
