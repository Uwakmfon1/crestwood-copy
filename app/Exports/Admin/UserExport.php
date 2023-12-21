<?php

namespace App\Exports\Admin;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromArray, WithHeadings
{
    private $type;
    private $from;
    private $to;

    public function __construct($type, $from, $to)
    {
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
    }

    public function array(): array
    {
        switch ($this->type){
            case 'verified':
                $users = User::query()->latest()->whereNotNull('email_verified_at');
                break;
            case 'unverified':
                $users = User::query()->latest()->whereNull('email_verified_at');
                break;
            default:
                $users = User::query()->latest();
        }
        $users = $users->whereDate('created_at', '>=', $this->from)
                        ->whereDate('created_at', '<=', $this->to)
                        ->get();
        return $users->map(function($user){
            return [
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone_code'] ? "+(".$user['phone_code'].')'.$user['phone'] : 'Not set',
                'state' => $user['state'] ?? 'Not set',
                'country' => $user['country'] ?? 'Not set',
                'city' => $user['city'] ?? 'Not set',
                'address' => $user['address'] ?? 'Not set',
                'bank_details' => $user['bank_name'] ? $user['bank_name'] .' - '. $user['account_number'] .' - '. $user['account_name'] : "Not set",
                'next_of_kin_name' => $user['nk_name'] ?? 'Not set',
                'next_of_kin_phone' => $user['nk_phone'] ?? 'Not set',
                'next_of_kin_address' => $user['nk_address'] ?? 'Not set',
                'date_joined' => $user->created_at->format('M d, Y'),
                'email_verification' => $user['email_verified_at'] ? 'Verified' : 'Unverified',
                'status' => $user['active'] == 1 ? 'Active' : 'Blocked'
            ];
        })->toArray(); 
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'phone',
            'state',
            'country',
            'city',
            'address',
            'bank details',
            'next of kin name',
            'next of kin phone',
            'next of kin address',
            'date joined',
            'email verification',
            'status',
        ];
    }
}
