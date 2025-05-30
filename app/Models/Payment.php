<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory; // Add this line

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_method',
        'amount',
        'status',
        'card_number',
        'card_name',
        'expiry_date',
        'cvv',
        'payment_date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
