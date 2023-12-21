<?php

namespace App\Exports;

use App\Trade;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TradeExport implements FromArray, WithHeadings
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function array(): array
    {
        switch ($this->type){
            case 'buy':
                $trades = auth()->user()->trades()->latest()->where('type', 'buy')->get();
                break;
            case 'sell':
                $trades = auth()->user()->trades()->latest()->where('type', 'sell')->get();
                break;
            default:
                $trades = auth()->user()->trades()->latest()->get();
        }
        return $trades->map(function($trade){
            return [
                'product' => ucfirst($trade->product),
                'type' => ucfirst($trade->type),
                'amount' => '₦ '.number_format($trade->amount),
                'grams' => round($trade->grams, 6),
                'date' => $trade->created_at->format('M d, Y'),
                'status' => $trade->status
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'product',
            'type',
            'amount',
            'grams',
            'date',
            'status',
        ];
    }
}
