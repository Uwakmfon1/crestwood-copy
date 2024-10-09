<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trading(): HasMany
    {
        return $this->hasMany(Trading::class);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
