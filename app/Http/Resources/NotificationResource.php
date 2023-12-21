<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Soundasleep\Html2Text;

class NotificationResource extends JsonResource
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
            'title' => $this['data']['title'],
            'body' => Html2Text::convert($this['data']['body']),
            'read' => !is_null($this['read_at']),
            "read_at" => $this['read_at'] ? $this['read_at']->format('M d, Y \a\t h:i A') : null,
            "created_at" => $this['created_at']->format('M d, Y \a\t h:i A'),
        ];
    }
}
