<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function investmentTransaction(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }
}
