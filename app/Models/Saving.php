<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saving extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['saving_date', 'return_date'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(SavingPackage::class, 'savings_package_id');
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function answers()
    {
        return $this->hasMany(SavingsAnswer::class);
    }

    public function getQuestion()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function isReadyForDeduction()
    {
        $currentDate = Carbon::now();
        $nextPaymentDate = $this->getNextPaymentDate();

        return $currentDate->isSameDay($nextPaymentDate);
    }

    private function getNextPaymentDate()
    {
        $duration = $this->duration;
        $lastDeductionDate = $this->return_date;
        switch ($duration) {
            case 'daily':
                return $lastDeductionDate->addDay();
            case 'weekly':
                return $lastDeductionDate->addWeek();
            case 'monthly':
                return $lastDeductionDate->addMonth();
            default:
                return $lastDeductionDate->addDay();
        }
    }

    public function savingsTransactions(): HasMany
    {
        return $this->hasMany(SaveTransaction::class);
    }
}
