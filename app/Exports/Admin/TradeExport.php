<?php

namespace App\Exports\Admin;

use App\Models\Trade;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TradeExport implements FromArray, WithHeadings
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
            case 'buy':
                $trades = Trade::query()->latest()->where('type', 'buy');
                break;
            case 'sell':
                $trades = Trade::query()->latest()->where('type', 'sell');
                break;
            default:
                $trades = Trade::query()->latest();
        }
        $trades = $trades->whereDate('created_at', '>=', $this->from)
                        ->whereDate('created_at', '<=', $this->to)
                        ->get();
        return $trades->map(function($trade){
            return [
                'name' => ucwords($trade->user['name']),
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
            'name',
            'product',
            'type',
            'amount',
            'grams',
            'date',
            'status',
        ];
    }
}
