<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        return $this->ledgerEntries()->where('type', 'debit');
    }

    public function credits(): MorphMany
    {
        return $this->ledgerEntries()->where('type', 'credit');
    }
}
