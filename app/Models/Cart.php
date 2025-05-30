<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
// A cart item belongs to a user
public function user(){
    return $this->belongsTo(User::class);
}

// A cart item belongs to a product
public function product(){
    return $this->belongsTo(Product::class);
}

// A cart item belongs to a product
public function order(){
    return $this->belongsTo(Order::class);
}
}
