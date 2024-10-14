<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use InvalidArgumentException;

class Ledger extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgerable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function debit(
        Wallet $accountToDebit,
        float $amount,
        string $account,
        Wallet $accountToCredit = null,
        string $reason = null
    ): void 
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Invalid amount');
        }
        if ($accountToDebit->balance() < $amount) {
            throw new InvalidArgumentException('Insufficient wallet balance');
        }

        $accountToDebit->ledgerEntries()->create([
            'old_balance' => $accountToDebit->balance(),
            'new_balance' => $accountToDebit->balance() - $amount,
            'type' => 'debit',
            'reason' => $reason ?: 'Debit',
            'amount' => $amount,
            'account' => $account,
        ]);
    }

    public static function credit(
        Wallet $accountToCredit,
        float $amount,
        string $account,
        Wallet $accountToDebit = null,
        string $reason = null
    ): void {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Invalid amount');
        }
        $accountToCredit->ledgerEntries()->create([
            'old_balance' => $accountToCredit->balance(),
            'new_balance' => $accountToCredit->balance() + $amount,
            'type' => 'credit',
            'reason' => $reason ?: 'Credit',
            'amount' => $amount,
            'account' => $account,
        ]);
    }

    public static function balance(Wallet $ledgerable): float
    {
        $credits = $ledgerable->credits()->sum('amount') ?? 0;
        $debits = $ledgerable->debits()->sum('amount') ?? 0;

        return $credits - $debits;
    }
}
