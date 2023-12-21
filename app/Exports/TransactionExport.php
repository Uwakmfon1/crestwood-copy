<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromArray, WithHeadings
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function array(): array
    {
        switch ($this->type){
            case 'withdrawal':
                $transactions = auth()->user()->transactions()->latest()->where('type', 'withdrawal')->get();
                break;
            case 'deposit':
                $transactions = auth()->user()->transactions()->latest()->where('type', 'deposit')->get();
                break;
            case 'others':
                $transactions = auth()->user()->transactions()->latest()->where('type', 'others')->get();
                break;
            default:
                $transactions = auth()->user()->transactions()->latest()->get();
        }
        return $transactions->map(function($transaction){
            return [
                'type' => ucfirst($transaction->type),
                'amount' => '₦ '.number_format($transaction->amount),
                'description' => $transaction->description,
                'method' => $transaction->method,
                'date' => $transaction->created_at->format('M d, Y'),
                'status' => $transaction->status
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'type',
            'amount',
            'description',
            'method',
            'date',
            'status',
        ];
    }
}
