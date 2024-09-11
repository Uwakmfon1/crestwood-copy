<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Package;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;

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
            'savings_package_id'=>$package['id'], 'slots' => $request['slots'], 'amount' => $request['slots'] * $package['price'],
            'total_return' => $request['slots'] * $package['price'] * (( 100 + $package['roi'] ) / 100 ),
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => 'active'
        ]);
        if ($investment) {
            TransactionController::storeInvestmentTransaction($investment, $request['payment'], 'investment', true);
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
        // Define all column names
        $columns = [
            'id', 'name', 'package', 'slots', 'total_invested', 'expected_returns', 'return_date', 'status', 'action'
        ];

        // Determine the query based on the type parameter
        switch ($type) {
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
                $packageId = $request->input('package');
                $investments = Investment::query()->latest()->whereHas('package', function ($q) use ($packageId) {
                    $q->where('id', $packageId);
                });
                break;
            default:
                $investments = Investment::query()->latest();
        }

        // Set helper variables from request and DB
        $totalData = $totalFiltered = $investments->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $orderColumn = $columns[$orderColumnIndex] ?? 'id';

        // Apply search filtering if necessary
        if (empty($searchValue)) {
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDirection)
                ->get();
        } else {
            $investments = $investments->where(function ($query) use ($searchValue) {
                $query->whereHas('user', function ($q) use ($searchValue) {
                    $q->where('name', 'LIKE', "%{$searchValue}%");
                })
                ->orWhereHas('package', function ($q) use ($searchValue) {
                    $q->where('name', 'LIKE', "%{$searchValue}%");
                })
                ->orWhere('slots', 'LIKE', "%{$searchValue}%")
                ->orWhere('status', 'LIKE', "%{$searchValue}%")
                ->orWhere('total_return', 'LIKE', "%{$searchValue}%")
                ->orWhere('amount', 'LIKE', "%{$searchValue}%");
            });
            $totalFiltered = $investments->count();
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDirection)
                ->get();
        }

        // Prepare data for DataTable
        $data = [];
        $i = $start + 1;
        foreach ($investments as $investment) {
            $status = $action = null;
            $user = $investment->user;
            $package = $investment->package;

            // Status badge
            switch ($investment->status) {
                case 'active':
                    $status = '<span class="badge badge-pill badge-success">Active</span>';
                    break;
                case 'pending':
                    $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                    if (Auth::user()->can('Approve Transactions') || Auth::user()->can('Decline Transactions')) {
                        $transactionId = optional($investment->transaction)->id;
                        $action = '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove'.$investment->id.'\')" href="'.route('admin.transactions.approve', $transactionId).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                                    <form id="transactionApprove'.$investment->id.'" action="'.route('admin.transactions.approve', $transactionId).'" method="POST">
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                        <input type="hidden" name="_method" value="PUT">
                                    </form>
                                    <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline'.$investment->id.'\')" href="'.route('admin.transactions.decline', $transactionId).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                                    <form id="transactionDecline'.$investment->id.'" action="'.route('admin.transactions.decline', $transactionId).'" method="POST">
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                        <input type="hidden" name="_method" value="PUT">
                                    </form>';
                    }
                    break;
                case 'cancelled':
                    $status = '<span class="badge badge-pill badge-danger">Cancelled</span>';
                    break;
                case 'settled':
                    $status = '<span class="badge badge-pill badge-secondary">Settled</span>';
                    break;
            }

            $data[] = [
                'sn' => $i,
                'name' => Auth::user()->can('View Users') && $user ? '<a href="'.route('admin.users.show', $user->id).'">'.ucwords($user->first_name) . ' ' . ucwords($user->last_name).'</a>' : 'Deleted Account',
                'package' => optional($package)->name,
                'slots' => $investment->slots,
                'total_invested' => '$ ' . number_format($investment->amount),
                'expected_returns' => '$ ' . number_format($investment->total_return),
                'return_date' => $investment->return_date->format('M d, Y'),
                'status' => $status,
                'action' => '<div class="dropdown">
                                <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <i class="icon-lg fa fa-angle-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item d-flex align-items-center" href="'.route('admin.investments.show', $investment->id).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>'.
                                    $action.'
                                </div>
                            </div>',
            ];
            $i++;
        }

        // Return results for DataTables
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }

}