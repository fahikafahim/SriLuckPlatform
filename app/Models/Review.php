<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model as Eloquent;


class Review extends Eloquent
{
    protected $connection = 'mongodb';
    protected $fillable = [
        'user_id',
        'product_id',
        'comment'
    ];

    // A review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A review belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
