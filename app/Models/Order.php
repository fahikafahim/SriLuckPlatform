<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'full_name',
        'email',
        'phone_number',
        'address',
        'postal_code',
        'city',
        'province',
        'cart_items', // Add this
    ];

    protected $casts = [
        'cart_items' => 'array', // This will automatically cast the JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
