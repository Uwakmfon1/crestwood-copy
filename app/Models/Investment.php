<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['investment_date', 'return_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function investmentTransaction(): HasMany
    {
        return $this->hasMany(InvestTransaction::class);
    }

    // public function transaction(): HasOne
    // {
    //     return $this->hasOne(Transaction::class);
    // }

    public function canSettle(): bool
    {
        return $this['return_date']->lte(now());
    }
}
