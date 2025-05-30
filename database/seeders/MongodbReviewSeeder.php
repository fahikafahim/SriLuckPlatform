<?php

namespace Database\Seeders;

use App\Models\mongodbReview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MongodbReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Sample reviews data
        $reviews = [
            [
                'user_id' => 1,
                'order_id' => 1001,
                'rating' => 5,
                'comment' => 'Excellent service and product quality!',
                'images' => ['review1_img1.jpg', 'review1_img2.jpg']
            ],
            [
                'user_id' => 2,
                'order_id' => 1002,
                'rating' => 4,
                'comment' => 'Good experience overall, but delivery was a bit late.',
                'images' => ['review2_img1.jpg']
            ],
            [
                'user_id' => 3,
                'order_id' => 1003,
                'rating' => 3,
                'comment' => 'Product was okay, not what I exactly expected.',
                'images' => []
            ],
            [
                'user_id' => 4,
                'order_id' => 1004,
                'rating' => 5,
                'comment' => 'Absolutely perfect! Will order again.',
                'images' => ['review4_img1.jpg', 'review4_img2.jpg', 'review4_img3.jpg']
            ],
            [
                'user_id' => 5,
                'order_id' => 1005,
                'rating' => 2,
                'comment' => 'Not satisfied with the product quality.',
                'images' => ['review5_img1.jpg']
            ],
        ];

        // Insert the reviews
        foreach ($reviews as $review) {
            mongodbReview::create($review);
        }


    }
}
