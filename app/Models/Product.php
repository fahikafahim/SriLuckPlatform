<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'color',
        'image_url'
    ];

// A product can have many cart items
public function cartItems(){
    return $this->hasMany(Cart::class);
}
 
}
