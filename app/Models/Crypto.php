<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crypto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cryptoTransactions(): MorphMany
    {
        return $this->morphMany(WalletsTransactions::class, 'transactable');
    }

    public function crypto(): BelongsTo
    {
        return $this->belongsTo(Crypto::class);
    }
}
