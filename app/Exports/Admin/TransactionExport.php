<?php

namespace App\Exports\Admin;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromArray, WithHeadings
{
    private $type;
    private $from;
    private $to;

    public function __construct($type, $from, $to)
    {
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
    }

    public function array(): array
    {
        switch ($this->type){
            case 'pending':
                $transactions = Transaction::query()->latest()->where('status', 'pending');
                break;
            case 'withdrawal':
                $transactions = Transaction::query()->latest()->where('type', 'withdrawal');
                break;
            case 'deposit':
                $transactions = Transaction::query()->latest()->where('type', 'deposit');
                break;
            case 'others':
                $transactions = Transaction::query()->latest()->where('type', 'others');
                break;
            default:
                $transactions = Transaction::query()->latest();
        }
        $transactions = $transactions->whereDate('created_at', '>=', $this->from)
                                    ->whereDate('created_at', '<=', $this->to)
                                    ->get();
        return $transactions->map(function($transaction){
            return [
                'name' => ucwords($transaction->user['name']),
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
            'name',
            'type',
            'amount',
            'description',
            'method',
            'date',
            'status',
        ];
    }
}
