<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Trading;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;

class TradingController extends Controller
{
    public function index()
    {
        $stock = Stock::paginate(20);
        $balance = auth()->user()->tradingWalletBalance();

        $buy_asset = Trading::
            where('user_id', auth()->id())->
            where('type', 'buy')->
            latest()->
            get();

            $totalBuyAmount = $buy_asset->sum(function($asset) {
                return $asset->amount * $asset->quantity;
            });

            $buyTrade = $buy_asset->count();

        $sell_asset = Trading::
            where('user_id', auth()->id())->
            where('type', 'sell')->
            latest()->
            get();

            $totalSellAmount = $sell_asset->sum(function($asset) {
                return $asset->amount * $asset->quantity;
            });

            $sellTrade = $sell_asset->count();

        $naira = 1568.23;

        return view('user_.trade.index', [
            'title' => 'Trading', 
            'stocks' => $stock, 
            'balance' => $balance, 
            'naira' => $naira,
            'buyAmount' => $totalBuyAmount,
            'buyTrade' => $buyTrade,
            'sellAmount' => $totalSellAmount,
            'sellTrade' => $sellTrade,
        ]);
    }



    public function packages()
    {
        return view('user.savings.packages.index', ['title' => 'Packages', 'packages' => SavingPackage::all()]);
    }

    public function create()
    {
        return view('user.savings.create', ['title' => 'Save', 'setting' => Setting::all()->first(), 'packages' => SavingPackage::all()]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'stock_id' => ['required'],
            'stock_symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:10'],
            'type' => ['required'],
            'quantity' => ['required', 'numeric', 'min:0.001'],
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Retrieve the stock data
        $stock = Stock::all()->where('id', $request['stock_id'])->first();

        $amount = ($request['amount'] * $request['quantity']);

        $stockAmount = ($request['quantity'] * $stock->price);

        // Check if the stock is tradeable
        if ($stock->tradeable == 0) {
            return back()->with('error', 'Trading ' . $stock->name . ' is currently unavailable, check back later');
        }

        $trade = null;

        // Process the trade based on the type (buy/sell)
        if ($request['type'] == 'buy') {
            // Check for sufficient balance
            if (!auth()->user()->hasSufficientBalance($amount, 'trading')) {
                return back()->withInput()->with('error', 'Insufficient trading balance');
            } else {
                // Handle buy trade
                $trade = $this->handleBuyTrade($request, $amount);
                auth()->user()->tradingWallet->decrement('balance', $amount);
            }
                
        } elseif ($request['type'] == 'sell') {
            // Handle sell trade
            $trade = $this->handleSellTrade($request, $stockAmount);
            if (!$trade) {
                return back()->with('error', 'Error processing sell trade');
            }
        }

        // Create a trading transaction
        $this->createTradingTransaction($trade, $amount, $request['type'], $stock['name']);

        // Set the success message
        if ($request['type'] == 'sell') {
            $msg = 'Sold out ' . $request['quantity'] . ' of ' . $stock['name'] . ' - $' . ($request['amount'] * $request['quantity']) . 'successfully';
        } else {
            $msg = 'Purchase of ' . $request['quantity'] . ' ' . $stock['name'] . ' - $' . ($request['amount'] * $request['quantity']) . ' was successful';
        }
    
        // Store the savings transaction and redirect
        if ($trade) {
            TransactionController::storeSavingTransaction($trade, $trade['amount'], $request['payment'], 'savings', 'Traded ' . $stock['name'], $trade['id']);
            return redirect()->route('assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing investment');
    }

    /**
     * Handle the buy trade logic.
     */
    private function handleBuyTrade($request, $amount)
    {
        $existingTrade = auth()->user()->trades()->where('stock_id', $request['stock_id'])->first();

        if ($existingTrade) {
            $existingTrade->increment('quantity', $request['quantity']);
            return $existingTrade;
        }

        return auth()->user()->trades()->create([
            'stock_id' => $request['stock_id'],
            'type' => $request['type'],
            'amount' => $request['amount'],
            'quantity' => $request['quantity'],
            'stock_symbol' => $request['stock_symbol']
        ]);
    }

    /**
     * Handle the sell trade logic.
     */
    private function handleSellTrade($request, $stockAmount)
    {
        $existingTrade = auth()->user()->trades()->where('stock_id', $request['stock_id'])->first();

        if ($existingTrade) {
            if ($existingTrade->quantity >= $request['quantity']) {
                $existingTrade->decrement('quantity', $request['quantity']);

                if ($existingTrade->quantity == 0) {
                    $existingTrade->delete();
                }

                auth()->user()->tradingWallet->increment('balance', $stockAmount);

                return $existingTrade;
            }

            return null; // Insufficient quantity to sell
        }

        return null; // No existing trade to sell
    }

    /**
     * Create a trading transaction.
     */
    private function createTradingTransaction($trade, $amount, $type, $stockName)
    {
        if ($type == 'buy') {
            $tradeType = 'withdrawal';
        } else {
            $tradeType = 'deposit';
        }
        
        $trade->tradingTransactions()->create([
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'type' => $tradeType,
            'account_type' => 'trading',
            'description' => $type . ' trade on ' . $stockName,
            'method' => 'wallet',
            'status' => 'approved'
        ]);
    }

    public function asset()
    {
        $assets = Trading::where('user_id', auth()->id())->latest()->get();
        $balance = auth()->user()->tradingWalletBalance();

        // Calculate the total amount of all trades
        $totalAmount = $assets->sum(function($asset) {
            return $asset->amount * $asset->quantity;
        });

        $naira = 1568.23;

        return view('user_.trade.asset', [
            'title' => 'Trading',
            'asset' => $assets->count(),
            'assets' => $assets,
            'balance' => $balance,
            'naira' => $naira,
            'totalAmount' => $totalAmount
        ]);
    }

    public function show (Stock $stock)
    {
        return view('user_.trade.show', [
            'title' => 'Trading', 
            'stock' => $stock, 
        ]);
    }


}
