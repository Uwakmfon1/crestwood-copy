<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgerEntries(): MorphMany
    {
        return $this->morphMany(Ledger::class, 'ledgerable');
    }

    public function balance(): float
    {
        return Ledger::balance($this);
    }

    public function debits(): MorphMany
    {
        return $this->ledgerEntries()->where('type', 'debit')->where('account', 'wallet');
    }

    public function credits(): MorphMany
    {
        return $this->ledgerEntries()->where('type', 'credit')->where('account', 'wallet');
    }

    public function deposit(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function sufficentAccountBalance(string $amount, string $account): float
    {
        $credit = $this->ledgerEntries()->where('type', 'credit')->where('account', $account)->sum('amount') ?? 0;
        $debit = $this->ledgerEntries()->where('type', 'debit')->where('account', $account)->sum('amount') ?? 0;

        $value = $credit - $debit;

        return $value >= $amount;
    }

    public function getAccountBalance(Wallet $wallet, string $account): float
    {
        // Sum credits and debits for the specific account type from the ledger
        $credits = $wallet->ledgerEntries()->where('account', $account)->where('type', 'credit')->sum('amount') ?? 0;
        $debits = $wallet->ledgerEntries()->where('account', $account)->where('type', 'debit')->sum('amount') ?? 0;

        return $credits - $debits;
    }
}
