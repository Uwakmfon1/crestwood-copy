<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'type' => $this['type'],
            'amount' => $this['amount'],
            'method' => $this['method'],
            'description' => $this['description'],
            'status' => $this['status'],
            'date' => $this['created_at']->format('M d, Y \a\t h:i A')
        ];
    }
}
