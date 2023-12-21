<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function investments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Investment::class);
    }

    public function rollovers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rollover::class);
    }

    public function canRunInvestment(): bool
    {
        return $this['investment'] == 'enabled' && Setting::all()->first()['invest'] == 1;
    }
}
