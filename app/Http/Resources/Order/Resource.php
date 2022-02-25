<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\OrderItem\Collection as OrderItemCollection;


class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "customerId" => $this->customer_id,
            'items' => new OrderItemCollection($this->items),
            'total' => $this->total
        ];
    }
}
