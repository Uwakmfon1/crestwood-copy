<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Trade;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard()
    {
        // return $this->investmentDashboard();
        $data = $this->getDashboardData();
        return view('admin.dashboard.index', [
            'transactions' => $data['transactions'],
            'investments' => $data['investments'],
            'paidInvestment' => ['reg' => $data['paidInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['paidInvestment'])],
            'totalInvestment' => ['reg' => $data['totalInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['totalInvestment'])],
        ]);
    }

    public function investmentDashboard()
    {
        $data = $this->getDashboardData();
        return view('admin.dashboard.investment', [
            'transactions' => $data['transactions'],
            'investments' => $data['investments'],
            'paidInvestment' => ['reg' => $data['paidInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['paidInvestment'])],
            'totalInvestment' => ['reg' => $data['totalInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['totalInvestment'])],
        ]);
    }

    public function tradingDashboard()
    {
        $data = $this->getDashboardData();
        return view('admin.dashboard.trading', [
            'transactions' => $data['transactions'],
            'tradesBuy' => $data['tradesBuy'],
            'tradesSell' => $data['tradesSell'],
            'investments' => $data['investments'],
            'paidInvestment' => ['reg' => $data['paidInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['paidInvestment'])],
            'totalInvestment' => ['reg' => $data['totalInvestment'], 'hf' => $this->formatHumanFriendlyNumber($data['totalInvestment'])],
        ]);
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function market()
    {
        return view('admin.market.index');
    }

    public function investmentMaturity()
    {
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return view('admin.maturity.index', ['months' => $months]);
    }

    public function download(Request $request)
    {
        if ($request['path']){
            return Response::download($request['path']);
        }
        return back()->with('error', 'Error downloading file');
    }

    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data');
        }
//        Update profile
        if (auth()->user()->update(['name' => $request['name']])){
            return back()->with('success', 'Profile updated successfully');
        }
        return back()->with('error', 'Error updating profile');
    }

    public function changePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'same:confirm_password'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->with('error', 'Invalid input data');
        }
//      Check if old password matches
        if (!Hash::check($request['old_password'], auth()->user()['password'])){
            return back()->with('error', 'Old password incorrect');
        }
//      Change password
        if (auth()->user()->update(['password' => Hash::make($request['new_password'])])){
            return back()->with('success', 'Password changed successfully');
        }
        return back()->with('error', 'Error changing password');
    }

    public function fetchInvestmentsMaturityWithAjax(Request $request)
    {
//        Define all column names
        $columns = [
            'id', 'name', 'package', 'slots', 'total_invested', 'expected_returns', 'return_date', 'status', 'action'
        ];
//        Find data
        $investments = Investment::query()->where('status', 'active')
                                            ->whereMonth('return_date', $request['month'])
                                            ->whereYear('return_date', $request['year'])
                                            ->orderByDesc('return_date');
//        Set helper variables from request and DB
        $totalData = $totalFiltered = $investments->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
//        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $investments = $investments->whereHas('user',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhereHas('package',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhere('slots', 'LIKE',"%{$search}%")
                ->orWhere('status', 'LIKE',"%{$search}%")
                ->orWhere('total_return', 'LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%");
            $totalFiltered = $investments->count();
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
//        Loop through all data and mutate data
        $data = [];
        foreach ($investments as $key=>$investment)
        {
            $status = $action = null;
            if($investment['status'] == 'active'){
                $status = '<span class="badge badge-pill badge-success">Active</span>';
            }elseif ($investment['status'] == 'pending'){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove'.$investment['id'].'\')" href="'.route('admin.transactions.approve', $investment['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                           <form id="transactionApprove'.$investment['id'].'" action="'.route('admin.transactions.approve', $investment['transaction']['id']).'" method="POST">
                               <input type="hidden" name="_token" value="'.csrf_token().'">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline'.$investment['id'].'\')" href="'.route('admin.transactions.decline', $investment['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                           <form id="transactionDecline'.$investment['id'].'" action="'.route('admin.transactions.decline', $investment['transaction']['id']).'" method="POST">
                               <input type="hidden" name="_token" value="'.csrf_token().'">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                if (!auth()->user()->can('Approve Transactions') && !auth()->user()->can('Decline Transactions')){
                    $action = null;
                }
            }elseif ($investment['status'] == 'cancelled'){
                $status = '<span class="badge badge-pill badge-danger">Cancelled</span>';
            }elseif ($investment['status'] == 'settled'){
                $status = '<span class="badge badge-pill badge-secondary">Settled</span>';
            }
            $datum['sn'] = $key + 1;
            if (auth()->user()->can('View Users')){
                $datum['name'] = '<a href="'.route('admin.users.show', $investment->user['id']).'">'.ucwords($investment->user['name']).'</a>';
            }else{
                $datum['name'] = ucwords($investment->user['name']);
            }
            $datum['package'] = $investment->package['name'];
            $datum['slots'] = $investment['slots'];
            $datum['total_invested'] = '₦ '.number_format($investment['amount']);
            $datum['expected_returns'] = '₦ '.number_format($investment['total_return']);
            $datum['return_date'] = $investment->return_date->format('M d, Y');
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item d-flex align-items-center" href="'.route('admin.investments.show', $investment['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>'.
                $action.'
                                        </div>
                                    </div>';
            $data[] = $datum;
        }
//      Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }

    protected function getDashboardData(): array
    {
        $transactionsMonth = [];
        $transactionsYear = [];
        $investmentsMonth = [];
        $investmentsYear = [];
        $tradesBuyMonth = [];
        $tradesSellMonth = [];
        $tradesBuyYear = [];
        $tradesSellYear = [];
//        Generate current month data
        for ($day = 1; $day <= date('t'); $day++){
            $transactionsMonth[] = round(Transaction::query()
                ->where('status', 'approved')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $investmentsMonth[] = round(Investment::query()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesBuyMonth[] = round(Trade::query()
                ->where(function ($q) { $q->where('type', 'stock')->orwhere('type', 'crypto'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesSellMonth[] = round(Trade::query()
                ->where(function ($q) { $q->where('type', 'stock')->orwhere('type', 'crypto'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
        }
//        Generate current year data
        for ($month = 1; $month <= 12; $month++){
            $transactionsYear[] = round(Transaction::query()
                ->where('status', 'approved')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->sum('amount'));
            $investmentsYear[] = round(Investment::query()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->sum('amount'));
            $tradesBuyYear[] = round(Trade::query()
            ->where(function ($q) { $q->where('type', 'stock')->orwhere('type', 'crypto'); })
            ->whereDate('created_at', date('Y-m') . '-' . $day)
            ->sum('amount'));
            $tradesSellYear[] = round(Trade::query()
            ->where(function ($q) { $q->where('type', 'stock')->orwhere('type', 'crypto'); })
            ->whereDate('created_at', date('Y-m') . '-' . $day)
            ->sum('amount'));
        }
//       compute paid investment data
        $paidInvestment = Investment::query()
            ->where('status', 'settled')
            ->sum('amount');
//       compute total investment data
        $totalInvestment = Investment::query()
            ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
            ->sum('amount');
        return [
            'transactions' => ['month' => $transactionsMonth, 'year' => $transactionsYear],
            'tradesBuy' => ['month' => $tradesBuyMonth, 'year' => $tradesBuyYear],
            'tradesSell' => ['month' => $tradesSellMonth, 'year' => $tradesSellYear],
            'investments' => ['month' => $investmentsMonth, 'year' => $investmentsYear],
            'paidInvestment' => $paidInvestment,
            'totalInvestment' => $totalInvestment
        ];
    }

    protected function formatHumanFriendlyNumber($num)
    {
        $num = (int) $num;
        if($num>1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }
}
