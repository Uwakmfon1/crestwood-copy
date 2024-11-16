<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function savingsTransactions(): BelongsTo
    {
        return $this->belongsTo(Saving::class);
    }
}
