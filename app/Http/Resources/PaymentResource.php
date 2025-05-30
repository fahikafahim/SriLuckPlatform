<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id'            => $this->id,
            'order_id'      => $this->order_id,
            'payment_method'=> $this->payment_method,
            'amount'        => $this->amount,
            'status'        => $this->status,
            'payment_date'  => $this->payment_date,
        ];
    }
}
