<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Crypto;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Trading;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use App\Models\AssetTransaction;
use App\Models\CryptoTransaction;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Models\CryptoTrade;

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

    public function crypto()
    {
        $stock = Crypto::paginate(20);
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

        return view('user_.crypto.index', [
            'title' => 'Cryptocurrency', 
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

    //STORE STOCKS 

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'stock_id' => ['required'],
            'stock_symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'type' => ['required'],
            'quantity' => ['required', 'numeric', 'min:0.00001'],
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
            $msg = 'Sold out ' . $request['quantity'] . ' of ' . $stock['name'] . ' $' . ($request['amount'] * $request['quantity']) . 'successfully';
        } else {
            $msg = 'Purchase of ' . $request['quantity'] . ' ' . $stock['name'] . ' $' . ($request['amount'] * $request['quantity']) . ' was successful';
        }
    
        // Store the savings transaction and redirect
        if ($trade) {
            TransactionController::storeSavingTransaction($trade, $trade['amount'], $request['payment'], 'savings', 'Traded ' . $stock['name'], $trade['id']);
            return redirect()->route('assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing investment');
    }

    private function handleBuyTrade($request, $amount)
    {
        $existingTrade = auth()->user()->trades()->where('stock_id', $request['stock_id'])->first();
        $stock = Stock::find($request['stock_id']); // Assuming you have stock data
        
        if ($existingTrade) {
            // Update the existing trade's quantity
            $existingTrade->increment('quantity', $request['quantity']);
        } else {
            // Create a new trade if it doesn't exist
            $existingTrade = auth()->user()->trades()->create([
                'stock_id' => $request['stock_id'],
                'type' => $request['type'],
                'amount' => $request['amount'],
                'quantity' => $request['quantity'],
                'stock_symbol' => $request['stock_symbol']
            ]);
        }

        // Create an asset transaction record for the buy trade
        AssetTransaction::create([
            'user_id' => auth()->id(),
            'stock_id' => $request['stock_id'],
            'price' => $stock->price, // Assuming you are storing the stock price
            'quantity' => $request['quantity'],
            'amount' => $amount,
            'profit' => 0, // Initial profit for buy trades would be 0
            'status' => 'open',
            'type' => 'buy',
        ]);

        return $existingTrade;
    }

    private function handleSellTrade($request, $stockAmount)
    {
        $existingTrade = auth()->user()->trades()->where('stock_id', $request['stock_id'])->first();
        $stock = Stock::find($request['stock_id']); // Fetch stock data

        if ($existingTrade) {
            if ($existingTrade->quantity >= $request['quantity']) {
                $existingTrade->decrement('quantity', $request['quantity']);

                if ($existingTrade->quantity == 0) {
                    $existingTrade->delete();
                }

                auth()->user()->tradingWallet->increment('balance', $stockAmount);

                // Calculate profit for the sell trade
                $profit = ($request['quantity'] * $stock->price) - ($existingTrade->amount); //this is wrong

                // Create an asset transaction record for the sell trade
                AssetTransaction::create([
                    'user_id' => auth()->id(),
                    'stock_id' => $request['stock_id'],
                    'price' => $stock->price,
                    'quantity' => $request['quantity'],
                    'amount' => $stockAmount,
                    'profit' => $profit, // Calculate profit for sell trades
                    'status' => 'closed',
                    'type' => 'sell',
                ]);

                return $existingTrade;
            }

            return null; // Insufficient quantity to sell
        }

        return null; // No existing trade to sell
    }
    
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

    // STORE CRYPTOCURRENCY

    public function storeCrypto(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'crypto_id' => ['required'],
            'crypto_symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'type' => ['required'],
            'lots' => ['required', 'numeric', 'min:0.00001'],
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Retrieve the crypto data
        $crypto = Crypto::find($request['crypto_id']);

        $amount = ($request['amount'] * $request['lots']);
        $cryptoAmount = ($request['lots'] * $crypto->price);

        // Check if the cryptocurrency is tradeable
        if ($crypto->tradeable == 0) {
            return back()->with('error', 'Trading ' . $crypto->name . ' is currently unavailable, check back later');
        }

        $trade = null;

        // Process the trade based on the type (buy/sell)
        if ($request['type'] == 'buy') {
            // Check for sufficient balance
            if (!auth()->user()->hasSufficientBalance($amount, 'trading')) {
                return back()->withInput()->with('error', 'Insufficient trading balance');
            } else {
                // Handle buy trade
                $trade = $this->handleBuyCrypto($request, $amount);
                auth()->user()->tradingWallet->decrement('balance', $amount);
            }

        } elseif ($request['type'] == 'sell') {
            // Handle sell trade
            $trade = $this->handleSellCrypto($request, $cryptoAmount);
            if (!$trade) {
                return back()->with('error', 'Error processing sell trade');
            }
        }

        // Create a crypto trading transaction
        $this->createCryptoTransaction($trade, $amount, $request['type'], $crypto->name);

        // Set the success message
        if ($request['type'] == 'sell') {
            $msg = 'Sold ' . $request['lots'] . ' of ' . $crypto->name . ' $' . ($request['amount'] * $request['lots']) . ' successfully';
        } else {
            $msg = 'Purchase of ' . $request['lots'] . ' ' . $crypto->name . ' $' . ($request['amount'] * $request['lots']) . ' was successful';
        }

        // Store the savings transaction and redirect
        if ($trade) {
            TransactionController::storeSavingTransaction($trade, $trade['amount'], $request['payment'], 'savings', 'Traded ' . $crypto->name, $trade['id']);
            return redirect()->route('crypto.assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing crypto trade');
    }

    private function handleBuyCrypto($request, $amount)
    {
        $existingTrade = auth()->user()->crypto()->where('crypto_id', $request['crypto_id'])->first();
        $crypto = Crypto::find($request['crypto_id']);

        if ($existingTrade) {
            // Update the existing trade's lots
            $existingTrade->increment('lots', $request['lots']);
        } else {
            // Create a new trade if it doesn't exist
            $existingTrade = auth()->user()->crypto()->create([
                'crypto_id' => $request['crypto_id'],
                'type' => $request['type'],
                'amount' => $request['amount'],
                'lots' => $request['lots'],
                'crypto_symbol' => $request['crypto_symbol'],
                'entry_price' => $crypto->price,
                'status' => 'open'
            ]);
        }

        // Create an asset transaction record for the buy trade
        CryptoTransaction::create([
            'user_id' => auth()->id(),
            'crypto_id' => $request['crypto_id'],
            'price' => $crypto->price, // Assuming you are storing the crypto price
            'lots' => $request['lots'],
            'amount' => $amount,
            'profit' => 0, // Initial profit for buy trades would be 0
            'status' => 'open',
            'type' => 'buy',
        ]);

        return $existingTrade;
    }

    private function handleSellCrypto($request, $cryptoAmount)
    {
        $validator = Validator::make($request->all(), [
            'crypto_id' => ['required'],
            'trans_id' => ['required'],
            'crypto_symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'type' => ['required'],
            'lots' => ['required', 'numeric', 'min:0.00001'],
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Retrieve the crypto data
        $crypto = Crypto::find($request['crypto_id']);

        $amount = ($request['amount'] * $request['lots']);
        $cryptoAmount = ($request['lots'] * $crypto->price);

        // Check if the cryptocurrency is tradeable
        if ($crypto->tradeable == 0) {
            return back()->with('error', 'Trading ' . $crypto->name . ' is currently unavailable, check back later');
        }

        $existingTrade = auth()->user()->crypto()->where('crypto_id', $request['crypto_id'])->first();

        $existingTransaction = auth()->user()->cryptoTransaction()->where('id', $request['trans_id'])->first();
        
        $crypto = Crypto::find($request['crypto_id']); // Fetch crypto data

        if ($existingTrade) {
            if ($existingTrade->lots >= $request['lots']) {

                $existingTrade->decrement('lots', $request['lots']);
                $existingTransaction->decrement('lots', $request['lots']);
                $existingTransaction->decrement('amount', $request['lots'] * $crypto->price);

                if ($existingTransaction->lots == 0) {
                    $existingTransaction->delete();
                    // CryptoTransaction::create([
                    //     'user_id' => auth()->id(),
                    //     'crypto_id' => $request['crypto_id'],
                    //     'price' => $crypto->price,
                    //     'lots' => $request['lots'],
                    //     'amount' => $cryptoAmount,
                    //     'profit' => $profit, // Calculate profit for sell trades
                    //     'status' => 'closed',
                    //     'type' => 'sell',
                    // ]);
                } else {

                }

                auth()->user()->tradingWallet->increment('balance', $cryptoAmount);

                // Calculate profit for the sell trade
                $profit = ($request['lots'] * $crypto->price) - ($existingTrade->entry_price * $request['lots']);

                // Create an asset transaction record for the sell trade
                // CryptoTransaction::create([
                //     'user_id' => auth()->id(),
                //     'crypto_id' => $request['crypto_id'],
                //     'price' => $crypto->price,
                //     'lots' => $request['lots'],
                //     'amount' => $cryptoAmount,
                //     'profit' => $profit, // Calculate profit for sell trades
                //     'status' => 'closed',
                //     'type' => 'sell',
                // ]);

                return $existingTrade;
            }

            return null; // Insufficient lots to sell
        }

        // Create a trading transaction
        $this->createTradingTransaction($existingTransaction, $amount, $request['type'], $crypto['name']);

        // Set the success message
        if ($request['type'] == 'sell') {
            $msg = 'Sold out ' . $request['quantity'] . ' of ' . $crypto['name'] . ' $' . ($request['amount'] * $request['quantity']) . 'successfully';
        } else {
            $msg = 'Purchase of ' . $request['quantity'] . ' ' . $crypto['name'] . ' $' . ($request['amount'] * $request['quantity']) . ' was successful';
        }
    
        // Store the savings transaction and redirect
        if ($existingTrade) {
            return redirect()->route('assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing investment');

        return null; // No existing trade to sell
    }

    private function createCryptoTransaction($trade, $amount, $type, $cryptoName)
    {
        if ($type == 'buy') {
            $tradeType = 'withdrawal';
        } else {
            $tradeType = 'deposit';
        }

        $trade->cryptoTransactions()->create([
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'type' => $tradeType,
            'account_type' => 'trading',
            'description' => $type . ' trade on ' . $cryptoName,
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

    public function cryptoAsset()
    {
        $assets = CryptoTrade::where('user_id', auth()->id())->latest()->get();
        $balance = auth()->user()->tradingWalletBalance();

        // Calculate the total amount of all trades
        $totalAmount = $assets->sum(function($asset) {
            return $asset->amount * $asset->quantity;
        });

        $naira = 1568.23;

        return view('user_.crypto.asset', [
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
        $assets = auth()->user()->assets()->where('stock_id', $stock->id)->get();

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($assets as $asset) {
            $totalCost += $asset->amount; // total amount spent on the asset
            $totalRevenue += $stock->price * $asset->quantity; // total value of asset at current price
        }

        $ownAsset = auth()->user()->trades()->where('stock_id', $stock->id)->first();
        $amount = $ownAsset ? ($ownAsset->amount * $ownAsset->quantity) : 0;
        $quantity = $ownAsset ? $ownAsset->quantity : 0;
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = $totalRevenue - $totalCost;
        $percentageOverallProfitLoss = $totalCost > 0 ? ($overallProfitLoss / $totalCost) * 100 : 0;

        return view('user_.trade.show', [
            'title' => 'Trading', 
            'stock' => $stock, 
            'asset' => $assets,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
        ]);
    }

    public function showCrypto (Crypto $stock)
    {
        $assets = auth()->user()->cryptoTransaction()->where('crypto_id', $stock->id)->get();

        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($assets as $asset) {
            $totalCost += $asset->amount; // total amount spent on the asset
            $totalRevenue += $stock->price * $asset->lots; // total value of asset at current price
        }

        $ownAsset = auth()->user()->crypto()->where('crypto_id', $stock->id)->first();
        $amount = $ownAsset ? ($ownAsset->amount * $ownAsset->lots) : 0;
        $quantity = $ownAsset ? $ownAsset->lots : 0;
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = $totalRevenue - $totalCost;
        $percentageOverallProfitLoss = $totalCost > 0 ? ($overallProfitLoss / $totalCost) * 100 : 0;

        return view('user_.crypto.show', [
            'title' => 'Trading', 
            'stock' => $stock, 
            'asset' => $assets,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
        ]);
    }

    public function showAsset(Stock $stock)
    {
        $assets = auth()->user()->assets()->where('stock_id', $stock->id)->get();

        if ($assets->count() <= 0) {
            return back()->with('info', "You don't have any holdings on " . $stock->name);
        }

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($assets as $asset) {
            $totalCost += $asset->amount; // total amount spent on the asset
            $totalRevenue += $stock->price * $asset->quantity; // total value of asset at current price
        }

        $ownAsset = auth()->user()->trades()->where('stock_id', $stock->id)->first();
        $amount = $ownAsset ? ($ownAsset->amount * $ownAsset->quantity) : 0;
        $quantity = $ownAsset ? $ownAsset->quantity : 0;
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = $totalRevenue - $totalCost;
        $percentageOverallProfitLoss = $totalCost > 0 ? ($overallProfitLoss / $totalCost) * 100 : 0;

        return view('user_.trade.show-asset', [
            'title' => 'My Asset',
            'asset' => $assets,
            'stock' => $stock,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
        ]);
    }

    public function showCyptoTrade(Crypto $stock)
    {
        $assets = auth()->user()->cryptoTransaction()->where('crypto_id', $stock->id)->get();

        if ($assets->count() <= 0) {
            return back()->with('info', "You don't have any holdings on " . $stock->name);
        }

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($assets as $asset) {
            $totalCost += $asset->amount; // total amount spent on the asset
            $totalRevenue += $stock->price * $asset->lots; // total value of asset at current price
        }

        $ownAsset = auth()->user()->crypto()->where('crypto_id', $stock->id)->first();
        $amount = $ownAsset ? ($ownAsset->amount * $ownAsset->lots) : 0;
        $quantity = $ownAsset ? $ownAsset->lots : 0;
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = $totalRevenue - $totalCost;
        $percentageOverallProfitLoss = $totalCost > 0 ? ($overallProfitLoss / $totalCost) * 100 : 0;

        return view('user_.crypto.view', [
            'title' => 'My Asset',
            'asset' => $assets,
            'stock' => $stock,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
        ]);
    }

    public function closeTrade(AssetTransaction $assetTransaction)
    {
        $stock = Stock::find($assetTransaction->stock_id);
        if (!$stock) {
            return redirect()->back()->with('error', 'Stock not found.');
        }

        $existingHolding = auth()->user()->trades()->where('stock_id', $assetTransaction['stock_id'])->first();

        $stockAmount = $assetTransaction->quantity * $stock->price;

        if ($existingHolding->quantity > 0) {

            $existingHolding->decrement('quantity', $assetTransaction->quantity);

            if ($existingHolding->quantity == 0) {
                $existingHolding->delete();
            }

            auth()->user()->tradingWallet->increment('balance', $stockAmount);

            $assetTransaction->update([
                'type' => 'sell',
                'updated_at' => now(), 
            ]);

            return redirect()->back()->with('success', 'Trade closed successfully.');
        }

        // Handle failure (e.g., no quantity left to close)
        return redirect()->back()->with('error', 'Failed to close trade. Insufficient quantity.');
    }

    public function closeAllTrades(Stock $stock)
    {
        $openTrades = auth()->user()->assets()->where('type', 'buy')->where('stock_id', $stock->id)->get();

        if ($openTrades->isEmpty()) {
            return redirect()->back()->with('error', 'No open trades to close.');
        }

        foreach ($openTrades as $trade) {
            $stock = Stock::find($trade->stock_id);

            if (!$stock) {
                return redirect()->back()->with('error', 'Stock not found for trade ID: ' . $trade->id);
            }

            $stockAmount = $trade->quantity * $stock->price;
            
            auth()->user()->tradingWallet->increment('balance', $stockAmount);

            $trade->update([
                'type' => 'sell',
                'amount' => $stockAmount,
                'updated_at' => now(),
            ]);

            if ($trade->quantity == 0) {
                // $trade->delete();
            }
        }

        // Return a success message
        return redirect()->back()->with('success', 'All trades closed successfully.');
    }

    public function closeAllAssets(Crypto $stock)
    {
        $openTrades = auth()->user()->cryptoTransaction()->where('type', 'buy')->where('crypto_id', $stock->id)->get();

        if ($openTrades->isEmpty()) {
            return redirect()->back()->with('error', 'No open trades to close.');
        }

        foreach ($openTrades as $trade) {
            $stock = Crypto::find($trade->crypto_id);

            if (!$stock) {
                return redirect()->back()->with('error', 'Stock not found for trade ID: ' . $trade->id);
            }

            $stockAmount = $trade->lots * $stock->price;
            
            auth()->user()->tradingWallet->increment('balance', $stockAmount);

            $trade->update([
                'type' => 'sell',
                'amount' => $stockAmount,
                'updated_at' => now(),
            ]);

            if ($trade->quantity == 0) {
                // $trade->delete();
            }
        }

        // Return a success message
        return redirect()->back()->with('success', 'All trades closed successfully.');
    }
   
}
