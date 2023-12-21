<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'name' => $this['name'] ?? '',
            'email' => $this['email'] ?? '',
            'phone_code' => $this['phone_code'] ?? '',
            'phone' => $this['phone'] ?? '',
            'state' => $this['state'] ?? '',
            'country' => $this['country'] ?? '',
            'city' => $this['city'] ?? '',
            'address' => $this['address'] ?? '',
            'ref_code' => $this['ref_code'],
            'ref_link' => route('register').'?ref='.$this['ref_code'],
            'bank_name' => $this['bank_name'] ?? '',
            'account_name' => $this['account_name'] ?? '',
            'account_number' => $this['account_number'] ?? '',
            'next_of_kin_name' => $this['nk_name'] ?? '',
            'next_of_kin_phone' => $this['nk_phone'] ?? '',
            'next_of_kin_address' => $this['nk_address'] ?? '',
            'active' => $this['active'] == 1,
            'email_verified' => !is_null($this['email_verified_at']),
            'avatar' => $this['avatar'] ? asset($this['avatar']) : '',
            'identification' => $this['identification'] ? asset($this['identification']) : '',
            'joined_at' => $this['created_at']->format('M d, Y')
        ];
    }
}
