<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletsTransactions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function savingsWallet(): BelongsTo
    {
        return $this->belongsTo(SavingsWallet::class, 'transactable_id');
    }

    public function tradingWallet(): BelongsTo
    {
        return $this->belongsTo(TradingWallet::class, 'transactable_id');
    }

    public function investmentWallet(): BelongsTo
    {
        return $this->belongsTo(InvestmentWallet::class, 'transactable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
