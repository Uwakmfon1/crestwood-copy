<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolloverResource extends JsonResource
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
            'package' => new PackageResource($this['package']),
            'slots' => $this['slots'],
            'date' => $this['created_at']->format('M d, Y \a\t h:i A')
        ];
    }
}
