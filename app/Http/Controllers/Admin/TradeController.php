<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    public function index()
    {
        switch (true){
            case \request()->offsetExists('buy'):
                $type = 'buy';
                break;
            case \request()->offsetExists('sell'):
                $type = 'sell';
                break;
            default:
                $type = 'all';
        }
        return view('admin.trade.index', ['type' => $type]);
    }

    public function buy(User $user)
    {
        return view('admin.user.trade.buy', ['user' => $user, 'rate' => ['gold' => HomeController::fetchGoldBuyPriceInNGN(), 'silver' => HomeController::fetchSilverBuyPriceInNGN()]]);
    }

    public function sell(User $user)
    {
        return view('admin.user.trade.sell', ['user' => $user, 'rate' => ['gold' => HomeController::fetchGoldSellPriceInNGN(), 'silver' => HomeController::fetchSilverSellPriceInNGN()]]);
    }

    public function buyStore(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'currency' => ['required'],
            'payment' => ['required'],
            'product' => ['required', 'in:gold,silver']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Find user
        $user = User::all()->where('id', $request['user_id'])->first();
        if (!$user) {
            return back()->with('error', 'Can\'t process investment, user not found');
        }
//        Calculate grams of gold to buy
        if($request['product'] == 'gold'){
            $gramsToNgn = \App\Http\Controllers\HomeController::fetchGoldBuyPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = \App\Http\Controllers\HomeController::fetchSilverBuyPriceInNGN();
        }else{
            $gramsToNgn = 0;
        }
        if ($gramsToNgn == 0){
            return back()->with('error', 'There was an error fetching exchange rates, reload page');
        }
        if ($request['currency'] == 'ngn'){
            $grams = round(($request['amount'] / $gramsToNgn), 6);
            $amount = round($request['amount'], 2);
        }else{
            $grams = round($request['amount'], 6);
            $amount = round($request['amount'] * $gramsToNgn, 2);
        }
//        Process trade based on payment method
        if ($request['payment'] == 'wallet'){
            if (!$user->hasSufficientBalanceForTransaction($amount)){
                return back()->withInput()->with('error', 'Insufficient wallet balance');
            }
            $user->nairaWallet()->decrement('balance', $amount);
        }
        if($request['product'] == 'gold'){
            $user->goldWallet()->increment('balance', $grams);
        }elseif($request['product'] == 'silver'){
            $user->silverWallet()->increment('balance', $grams);
        }
//        Create trade
        $trade = $user->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'type' => 'buy', 'product' => $request['product'], 'status' => 'success'
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, $request['payment'],true);
            NotificationController::sendTradeSuccessfulNotification($trade);
            return redirect()->route('admin.users.show', $user['id'])->with('success', 'Trade completed successfully');
        }
        return back()->withInput()->with('error', 'Error processing trade');
    }

    public function sellStore(Request $request)
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'currency' => ['required'],
            'product' => ['required', 'in:gold,silver']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Find user
        $user = User::all()->where('id', $request['user_id'])->first();
        if (!$user) {
            return back()->with('error', 'Can\'t process investment, user not found');
        }
//        Calculate grams of gold to sell
        if($request['product'] == 'gold'){
            $gramsToNgn = \App\Http\Controllers\HomeController::fetchGoldSellPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = \App\Http\Controllers\HomeController::fetchSilverSellPriceInNGN();
        }else{
            $gramsToNgn = 0;
        }
        if ($gramsToNgn == 0){
            return back()->with('error', 'There was an error fetching exchange rates, reload page');
        }
        if ($request['currency'] == 'ngn'){
            $grams = round(($request['amount'] / $gramsToNgn), 6);
            $amount = round($request['amount'], 2);
        }else{
            $grams = round($request['amount'], 6);
            $amount = round($request['amount'] * $gramsToNgn, 2);
        }
//        Process trade
        if($request['product'] == 'gold'){
            if (! $user->hasSufficientGoldToTrade($grams)){
                return back()->withInput()->with('error', 'Insufficient gold wallet balance');
            }
            $user->goldWallet()->decrement('balance', $grams);
        }elseif($request['product'] == 'silver'){
            if (! $user->hasSufficientSilverToTrade($grams)){
                return back()->withInput()->with('error', 'Insufficient silver wallet balance');
            }
            $user->silverWallet()->decrement('balance', $grams);
        }
        $user->nairaWallet()->increment('balance', $amount);
//        Create trade
        $trade = $user->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'product' => $request['product'], 'type' => 'sell', 'status' => 'success'
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, 'wallet',true);
            NotificationController::sendTradeSuccessfulNotification($trade);
            return redirect()->route('admin.users.show', $user['id'])->with('success', 'Trade completed successfully');
        }
        return back()->withInput()->with('error', 'Error processing trade');
    }
    public function fetchTradesWithAjax(Request $request, $type)
    {
//        Define all column names
        $columns = [
            'id', 'name', 'symbol', 'amount', 'quantity', 'type', 'date', 'status', 'action'
        ];
//        Find data based on page
        switch ($type){
            case 'buy':
                $trades = Trade::query()->latest()->where('type', 'buy');
                break;
            case 'sell':
                $trades = Trade::query()->latest()->where('type', 'sell');
                break;
            default:
                $trades = Trade::query()->latest();
        }
//        Set helper variables from request and DB
        $totalData = $totalFiltered = $trades->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
//        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $trades = $trades->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $trades = $trades->where('grams','LIKE',"%{$search}%")
                ->orWhereHas('user',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('status', 'LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%");
            $totalFiltered = $trades->count();
            $trades = $trades->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
//        Loop through all data and mutate data
        $data = [];
        $i = $start + 1;
        foreach ($trades as $trade)
        {
            $status = $action = $disabled = null;
            if($trade['status'] == 'success'){
                $status = '<span class="badge badge-pill badge-success">Success</span>';
                $disabled = 'disabled';
            }elseif ($trade['status'] == 'pending'){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                if (auth()->user()->can('Approve Transactions')) {
                    $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove' . $trade['id'] . '\')" href="' . route('admin.transactions.approve', $trade['transaction']['id']) . '"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                           <form id="transactionApprove' . $trade['id'] . '" action="' . route('admin.transactions.approve', $trade['transaction']['id']) . '" method="POST">
                               <input type="hidden" name="_token" value="' . csrf_token() . '">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                }
                if (auth()->user()->can('Decline Transactions')) {
                    $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline' . $trade['id'] . '\')" href="' . route('admin.transactions.decline', $trade['transaction']['id']) . '"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                            <form id="transactionDecline' . $trade['id'] . '" action="' . route('admin.transactions.decline', $trade['transaction']['id']) . '" method="POST">
                               <input type="hidden" name="_token" value="' . csrf_token() . '">
                               <input type="hidden" name="_method" value="PUT">
                            </form>';
                }
                if (!auth()->user()->can('Approve Transactions') && !auth()->user()->can('Decline Transactions')){
                    $disabled = 'disabled';
                }
            }elseif ($trade['status'] == 'failed'){
                $status = '<span class="badge badge-pill badge-danger">Failed</span>';
                $disabled = 'disabled';
            }
            if ($trade['type']){
                $type = '<span class="badge badge-success">Buy</span>';
            }else{
                $type = '<span class="badge badge-danger">Sell</span>';
            }
            if ($trade['type'] == 'stocks'){
                $product = '<span class="badge badge-gold">Stocks</span>';
            }else{
                $product = '<span class="badge badge-silver">Crpyto</span>';
            }
            $datum['sn'] = $i;
            if (auth()->user()->can('View Users')){
                $datum['name'] = '<a href="'.route('admin.users.show', $trade->user['id']).'">'.ucwords($trade->user['first_name']) . ' ' . ucwords($trade->user['last_name'] ).'</a>';
            }else{
                $datum['name'] = ucwords($trade->user['name']);
            }
            $datum['grams'] = ucwords($trade['symbol']);
            $datum['amount'] = '$'.number_format($trade['amount'], 4);
            $datum['product'] = $product;
            $datum['type'] = $type;
            $datum['date'] = $trade['created_at']->format('M d, Y');
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" '.$disabled.' type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            '.$action.'
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
