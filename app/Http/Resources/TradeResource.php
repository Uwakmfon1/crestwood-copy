<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'units' => round($this['grams'], 6),
            'amount' => $this['amount'],
            'product' => $this['product'],
            'type' => $this['type'],
            'status' => $this['status'],
            'date' => $this['created_at']->format('M d, Y \a\t h:i A')
        ];
    }
}
