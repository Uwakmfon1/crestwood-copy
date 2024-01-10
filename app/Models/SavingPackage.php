<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingPackage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function savings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Saving::class, 'savings_package_id');
    }
}
