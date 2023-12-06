<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Models\Investment;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function index()
    {
        return view('admin.investment.index', ['type' => \request('type') ?? 'all']);
    }

    public function show(Investment $investment)
    {
        return view('admin.investment.show', ['investment' => $investment, 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function invest(User $user)
    {
        return view('admin.user.investment.add', ['packages' => Package::where('investment', 'enabled')->get(), 'user' => $user]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1', 'integer'],
            'payment' => ['required']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Find package and check if investment is enabled
        $package = Package::all()->where('name', $request['package'])->first();
        if (!($package && $package->canRunInvestment())){
            return back()->with('error', 'Can\'t process investment, package not found or disabled');
        }
//        Find user
        $user = User::all()->where('id', $request['user_id'])->first();
        if (!$user) {
            return back()->with('error', 'Can\'t process investment, user not found');
        }
//        Process investment based on payment method
        if ($request['payment'] == 'wallet'){
            if (!$user->hasSufficientBalanceForTransaction($request['slots'] * $package['price'])){
                return back()->withInput()->with('error', 'Insufficient wallet balance');
            }
            $user->nairaWallet()->decrement('balance', $request['slots'] * $package['price']);
        }
//        Create Investment
        $investment = $user->investments()->create([
            'package_id'=>$package['id'], 'slots' => $request['slots'], 'amount' => $request['slots'] * $package['price'],
            'total_return' => $request['slots'] * $package['price'] * (( 100 + $package['roi'] ) / 100 ),
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => 'active'
        ]);
        if ($investment) {
            TransactionController::storeInvestmentTransaction($investment, $request['payment'], true);
            NotificationController::sendInvestmentCreatedNotification($investment);
            return redirect()->route('admin.users.show', $user['id'])->with('success', 'Investment created successfully');
        }
        return back()->withInput()->with('error', 'Error processing investment');
    }

    public function showUserInvestment(User $user, Investment $investment)
    {
        return view('admin.user.investment.show', ['user' => $user, 'investment' => $investment, 'packages' => Package::all()]);
    }

    public function fetchInvestmentsWithAjax(Request $request, $type)
    {
        //        Define all column names
        $columns = [
            'id', 'name', 'package', 'slots', 'total_invested', 'expected_returns', 'return_date', 'status', 'action'
        ];
//        Find data based on page
        switch ($type){
            case 'active':
                $investments = Investment::query()->latest()->where('status', 'active');
                break;
            case 'pending':
                $investments = Investment::query()->latest()->where('status', 'pending');
                break;
            case 'cancelled':
                $investments = Investment::query()->latest()->where('status', 'cancelled');
                break;
            case 'settled':
                $investments = Investment::query()->latest()->where('status', 'settled');
                break;
            case 'packages':
                $investments = Investment::query()->latest()->whereHas('package',function ($q) use ($request) { $q->where('id', $request['package']); });
                break;
            default:
                $investments = Investment::query()->latest();

        }
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
        $i = $start + 1;
        foreach ($investments as $investment)
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
            $datum['sn'] = $i;
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
            $i++;
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
}
