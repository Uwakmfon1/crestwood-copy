<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\InvestmentExport;
use App\Exports\Admin\TradeExport;
use App\Exports\Admin\TransactionExport;
use App\Exports\Admin\UserExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportUsers($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new UserExport($type, request()->get('from'), request()->get('to')), 'users.xlsx');
    }
    public function exportInvestments($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new InvestmentExport($type, request()->get('from'), request()->get('to')), 'investments.xlsx');
    }

    public function exportTransactions($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new TransactionExport($type, request()->get('from'), request()->get('to')), 'transactions.xlsx');
    }

    public function exportTrades($type): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new TradeExport($type, request()->get('from'), request()->get('to')), 'trades.xlsx');
    }
}
