<?php

namespace App\Http\Controllers;

use App\Exports\InvestmentExport;
use App\Exports\TradeExport;
use App\Exports\TransactionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportInvestments($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new InvestmentExport($type), 'investments.xlsx');
    }

    public function exportTransactions($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new TransactionExport($type), 'transactions.xlsx');
    }

    public function exportTrades($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new TradeExport($type), 'trades.xlsx');
    }
}
