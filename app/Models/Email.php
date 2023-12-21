<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function canMarkAsFailed(): bool
    {
        $closeDate = date('Y-m-d H:i:s', strtotime($this['updated_at'].' + 24 hours'));
        return now()->gt($closeDate);
    }
}
