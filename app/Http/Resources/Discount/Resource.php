<?php

namespace App\Http\Resources\Discount;

use Illuminate\Http\Resources\Json\JsonResource;


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
            'orderId' => $this->id,
            'discounts' => $this->discounts,
            "totalDiscount" => $this->totalDiscount,
            'discountedTotal' => $this->discountedTotal,
        ];
    }
}

/*
['id'],
            'discounts' => [
                'discountReason' => $this['discount']['reason'],
                'discountAmount' => $this['discount']['amount'],
                'subtotal' => $this['discount']['subtotal'],
            ],

*/