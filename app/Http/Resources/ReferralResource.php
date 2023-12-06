<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $user = $this->referred;
        return [
            'id' => $this['id'],
            'date_referred' => $this['created_at']->format('M d, Y'),
            'user_details' => [
                'id' => $user['id'],
                'name' => $user['name'] ?? '',
                'email' => $user['email'] ?? '',
                'phone_code' => $user['phone_code'] ?? '',
                'phone' => $user['phone'] ?? '',
                'state' => $user['state'] ?? '',
                'country' => $user['country'] ?? '',
                'city' => $user['city'] ?? '',
                'address' => $user['address'] ?? '',
                'active' => $user['active'] == 1,
                'email_verified' => !is_null($user['email_verified_at']),
                'avatar' => $user['avatar'] ? asset($user['avatar']) : '',
                'joined_at' => $user['created_at']->format('M d, Y')
            ]
        ];
    }
}
