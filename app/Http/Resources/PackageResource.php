<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $suffix = $this['duration'] > 1 ? " months" : " month";
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'roi' => $this['roi'],
            'duration' => $this['duration'].$suffix,
            'price_per_slot' => $this['price'],
            'description' => $this['description'],
            'image' => asset($this['image']),
            'investment' => $this['investment']
        ];
    }
}
