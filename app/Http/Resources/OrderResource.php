<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id'       => $this->user_id,
            'status'        => $this->status,
            'total_amount'  => $this->total_amount,
            'full_name'     => $this->full_name,
            'email'         => $this->email,
            'phone_number'  => $this->phone_number,
            'address'       => $this->address,
            'postal_code'   => $this->postal_code,
            'city'          => $this->city,
            'province'      => $this->province,
            'cart_items'    => $this->cart_items, 
            'create_date'   => $this->create_date,
            'update_date'   => $this->update_date,
            'created_at'    => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at'    => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
