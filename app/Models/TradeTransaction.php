<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradeTransaction extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function tradeTransaction(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
