<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
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
            "id" => $this['id'],
            "package" => new PackageResource($this['package']),
            "slots" => $this['slots'],
            "amount" => $this['amount'],
            "investment_date" => $this['investment_date']->format('M d, Y \a\t h:i A'),
            "return_date" => $this['return_date']->format('M d, Y \a\t h:i A'),
            "rollover" => new RolloverResource($this['rollover']),
            "status" => $this['status']
        ];
    }
}
