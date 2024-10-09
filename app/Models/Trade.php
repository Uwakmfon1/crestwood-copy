<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function tradeTransaction(): HasMany
    {
        return $this->hasMany(TradeTransaction::class, 'trade_id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'data_id');
    }

    public function crypto(): BelongsTo
    {
        return $this->belongsTo(Crypto::class, 'data_id');
    }
}
