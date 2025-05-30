<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::create([
    'user_id' => 1,
    'product_id' => 1,
    'comment' => 'Sample review'
]);
        Review::create([
            'user_id' => 2,
            'product_id' => 1,
            'comment' => 'Another sample review'
        ]);
        Review::create([
            'user_id' => 3,
            'product_id' => 2,
            'comment' => 'Yet another sample review'
        ]);
        Review::create([
            'user_id' => 4,
            'product_id' => 2,
            'comment' => 'This is a sample review for product 2'
        ]);
        Review::create([
            'user_id' => 5,
            'product_id' => 3,
            'comment' => 'This is a sample review for product 3'
        ]);
        Review::create([
            'user_id' => 6,
            'product_id' => 3,
            'comment' => 'This is a sample review for product 3'
        ]);
    }
}
