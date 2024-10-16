<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    //:::: DESTROY FILE - NOT NEEDED :::://
    public function index()
    {
        $trades = auth()->user()->trades()->latest();
        switch (true){
            case \request()->offsetExists('buy'):
                $trades = $trades->where('type', 'buy');
                break;
            case \request()->offsetExists('sell'):
                $trades = $trades->where('type', 'sell');
                break;
        }
        return view('user.trade.index', ['title' => 'Trades', 'trades' => $trades->get()]);
    }

    public function showBuyForm()
    {
        return view('user.trade.buy', ['title' => 'Buy', 'setting' => Setting::all()->first(), 'rate' => ['gold' => HomeController::fetchGoldBuyPriceInNGN(), 'silver' => HomeController::fetchSilverBuyPriceInNGN()]]);
    }

    public function showSellForm()
    {
        return view('user.trade.sell', ['title' => 'Sell', 'setting' => Setting::all()->first(), 'rate' => ['gold' => HomeController::fetchGoldSellPriceInNGN(), 'silver' => HomeController::fetchSilverSellPriceInNGN()]]);
    }

    public function buy(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'currency' => ['required'],
            'payment' => ['required'],
            'product' => ['required', 'in:gold,silver']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Check if trading is allowed
        if (Setting::all()->first()['trade'] == 0){
            return back()->with('error', 'Buying is currently unavailable, check back later');
        }
//        Calculate grams of gold to buy
        if($request['product'] == 'gold'){
            $gramsToNgn = HomeController::fetchGoldBuyPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = HomeController::fetchSilverBuyPriceInNGN();
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
        switch ($request['payment']){
            case 'wallet':
                if (!auth()->user()->hasSufficientBalanceForTransaction($amount)){
                    return back()->withInput()->with('error', 'Insufficient wallet balance');
                }
                auth()->user()->nairaWallet()->decrement('balance', $amount);
                if($request['product'] == 'gold'){
                    auth()->user()->goldWallet()->increment('balance', $grams);
                }elseif($request['product'] == 'silver'){
                    auth()->user()->silverWallet()->increment('balance', $grams);
                }
                $status = 'success';
                $msg = 'Trade completed successfully';
                break;
            case 'deposit':
                $status = 'pending';
                $msg = 'Trade queued successfully';
                break;
            case 'card':
                $data = ['type' => 'trade', 'product' => $request['product'], 'grams' => $grams];
                return PaymentController::initializeOnlineTransaction($amount, $data);
            default:
                return back()->withInput()->with('error', 'Invalid payment method');
        }
//        Create trade
        $trade = auth()->user()->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'type' => 'buy', 'product' => $request['product'], 'status' => $status
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, $request['payment']);
            if ($trade['status'] == 'success'){
                NotificationController::sendTradeSuccessfulNotification($trade);
            }else{
                NotificationController::sendTradeQueuedNotification($trade);
            }
            return redirect()->route('trades')->with('success', $msg);
        }
        return back()->withInput()->with('error', 'Error processing trade');
    }

    public function sell(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'currency' => ['required'],
            'product' => ['required', 'in:gold,silver']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Check if trading is allowed
        if (Setting::all()->first()['trade'] == 0){
            return back()->with('error', 'Selling is currently unavailable, check back later');
        }
//        Calculate grams of gold to sell
        if($request['product'] == 'gold'){
            $gramsToNgn = HomeController::fetchGoldSellPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = HomeController::fetchSilverSellPriceInNGN();
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
            if (!auth()->user()->hasSufficientGoldToTrade($grams)){
                return back()->withInput()->with('error', 'Insufficient gold wallet balance');
            }
            auth()->user()->goldWallet()->decrement('balance', $grams);
        }elseif($request['product'] == 'silver'){
            if (!auth()->user()->hasSufficientSilverToTrade($grams)){
                return back()->withInput()->with('error', 'Insufficient silver wallet balance');
            }
            auth()->user()->silverWallet()->decrement('balance', $grams);
        }
        auth()->user()->nairaWallet()->increment('balance', $amount);
//        Create trade
        $trade = auth()->user()->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'product' => $request['product'], 'type' => 'sell', 'status' => 'success'
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, 'wallet');
            NotificationController::sendTradeSuccessfulNotification($trade);
            return redirect()->route('trades')->with('success', 'Trade completed successfully');
        }
        return back()->withInput()->with('error', 'Error processing trade');
    }
}
