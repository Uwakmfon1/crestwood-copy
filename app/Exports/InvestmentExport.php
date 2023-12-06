<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvestmentExport implements FromArray, WithHeadings
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function array(): array
    {
        switch ($this->type){
            case 'pending':
                $investments = auth()->user()->investments()->latest()->where('status', 'pending')->get();
                break;
            case 'active':
                $investments = auth()->user()->investments()->latest()->where('status', 'active')->get();
                break;
            case 'cancelled':
                $investments = auth()->user()->investments()->latest()->where('status', 'cancelled')->get();
                break;
            case 'settled':
                $investments = auth()->user()->investments()->latest()->where('status', 'settled')->get();
                break;
            default:
                $investments = auth()->user()->investments()->latest()->get();
        }
        return $investments->map(function($investment){
            return [
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
