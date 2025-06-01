<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class mongodbReview extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'mongodbreviews';

    protected $fillable = [
        'user_id',
        'order_id',
        'rating',
        'comment',
        'images'
    ];

    protected $casts = [
        'rating' => 'integer',
        'images' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
