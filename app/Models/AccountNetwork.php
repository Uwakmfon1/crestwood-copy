<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountNetwork extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function addresses()
    {
        return $this->hasMany(AccountAddress::class);
    }
}
