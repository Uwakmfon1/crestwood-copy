<?php

namespace App\Exports\Admin;

use App\Models\Investment;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvestmentExport implements FromArray, WithHeadings
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
                $investments = Investment::query()->latest()->where('status', 'pending');
                break;
            case 'active':
                $investments = Investment::query()->latest()->where('status', 'active');
                break;
            case 'cancelled':
                $investments = Investment::query()->latest()->where('status', 'cancelled');
                break;
            case 'settled':
                $investments = Investment::query()->latest()->where('status', 'settled');
                break;
            default:
                $investments = Investment::query()->latest();
        }
        $investments = $investments->whereDate('created_at', '>=', $this->from)
                                    ->whereDate('created_at', '<=', $this->to)
                                    ->get();
        return $investments->map(function($investment){
            return [
                'name' => $investment->user['name'],
                'package' => $investment->package['name'],
                'slots' => $investment->slots,
                'amount' => '₦ '.number_format($investment->amount),
                'total return' => '₦ '.number_format($investment->total_return),
                'investment date' => $investment->investment_date->format('M d, Y'),
                'return date' => $investment->return_date->format('M d, Y'),
                'status' => $investment->status
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'name',
            'package',
            'slots',
            'amount',
            'total returns',
            'investment date',
            'return date',
            'status',
        ];
    }
}
