<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['investment_date', 'return_date'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function rollover(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Rollover::class);
    }

    public function hasRolledOver(): bool
    {
        return $this->rollover()->exists();
    }

    public function canSettle(): bool
    {
        return $this['return_date']->lte(now());
    }
}
