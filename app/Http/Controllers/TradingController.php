<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Crypto;
use App\Models\Ledger;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Trading;
use App\Models\CryptoTrade;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use InvalidArgumentException;
use App\Models\AssetTransaction;
use App\Models\TradeTransaction;
use App\Models\CryptoTransaction;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;

class TradingController extends Controller
{
    //:::: STOCKS CONTROLLER :::://
    public function index(Request $request)
    {
        $user = auth()->user();

        // Start with a base query for the stocks (crypto assets)
        $query = Stock::query();

        // If a search term is present, adjust the query to filter by name or symbol
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('symbol', 'like', '%' . $searchTerm . '%');
            });
        }

        $stock = $query->paginate(40);
        $balance = auth()->user()->wallet->trade;

        $tradeCount = $user->trades('stocks')->count();

        $totalStocks = $user->trades('stocks')->sum('amount');

        $slidesData = $this->getTopAssets();

        return view('user_.trade.index', [
            'title' => 'Trading', 
            'stocks' => $stock, 
            'balance' => $balance, 
            'tradeCount' => $tradeCount,
            'totalStocks' => $totalStocks,

            'buyAmount' => 0,
            'buyTrade' => 0,
            'sellAmount' => 0,
            'sellTrade' => 0,

            'slidesData' => $slidesData,
        ]);
    }

    private function getTopAssets()
    {
        // Fetch top 10 Stocks
        $stocks = Stock::orderBy('market_cap', 'desc')
            ->take(10)
            ->get();

        // Merge the cryptos and stocks into one collection (in this case, it's just stocks)
        $assets = $stocks;

        // Define the color classes
        $colors = ['success', 'primary', 'secondary', 'info', 'warning', 'danger', 'dark'];

        // Iterate over assets and assign random colors and img
        $assets = $assets->map(function ($asset) use ($colors) {
            // Shuffle the color array to get a random color each time
            $shuffledColors = $colors;
            shuffle($shuffledColors); // Shuffle the array

            return [
                'name' => $asset->name,
                'icon' => $asset->img,  // Use asset's img as the icon
                'colorClass' => $shuffledColors[0], // Randomly assigned color
                'price' => "$" . number_format($asset->price, 2), // Formatting price
                'percentageChange' => number_format($asset->changes_percentage, 2) . "%",
                'changeDirection' => "ti-arrow-bear-right", // You can replace with actual direction logic
                'changeAmount' => "$" . number_format($asset->change, 2),
            ];
        });

        // Shuffle the assets array to mix stocks randomly
        return $assets->shuffle(); // Return the shuffled assets directly as an array
    }

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

        $user = auth()->user();

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
            if (!$user->wallet->sufficentAccountBalance($amount, 'trade')) {
                return back()->withInput()->with('error', 'Insufficient trading balance');
            } else {
                // Handle buy trade
                $trade = $this->handleBuyTrade($request, $amount);

                // ::::: Store Ledger :::::: //
                try {
                    Ledger::debit($user->wallet, $amount, 'trade', null, 'Trade stocks...');
                } catch (InvalidArgumentException $e) {
                    return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
                }
                // ::::: Store Ledger :::::: //
            }
                
        } elseif ($request['type'] == 'sell') {
            // Handle sell trade
            $trade = $this->handleSellTrade($request, $stockAmount);
            if (!$trade) {
                return back()->with('error', 'Error processing sell trade');
            }

            try {
                Ledger::credit($user->wallet, $stockAmount, 'trade', null, 'Trade stocks sell...');
            } catch (InvalidArgumentException $e) {
                return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
            }
        }

        // Create a trading transaction
        $transaction = $user->transaction('trade')->create([
            'type' => 'trade',
            'amount' => $amount,
            'data_id' => $trade->id,
            'status' => 'approved',
            'description' => 'Stocks trade on ' . $stock->name
        ]);

        // Set the success message
        if ($request['type'] == 'sell') {
            $msg = 'Sold out ' . $request['quantity'] . ' of ' . $stock['name'] . ' $' . ($request['amount'] * $request['quantity']) . 'successfully';
        } else {
            $msg = 'Purchase of ' . $request['quantity'] . ' ' . $stock['name'] . ' $' . ($request['amount'] * $request['quantity']) . ' was successful';
        }
    
        // Store the savings transaction and redirect
        if ($transaction) {
            // TransactionController::storeSavingTransaction($trade, $trade['amount'], $request['payment'], 'savings', 'Traded ' . $stock['name'], $trade['id']);
            NotificationController::sendTradeNotification($trade, 'stock', $request['type']);

            return redirect()->route('assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing investment');
    }

    private function handleBuyTrade($request, $amount)
    {
        $user = auth()->user();

        $existingTrade = $user->trades('stocks')->where('data_id', $request['stock_id'])->first();
        
        if ($existingTrade) {
            $existingTrade->increment('quantity', $request['quantity']);
            $existingTrade->increment('amount', $request['quantity'] * $request['amount']);
        } else {
            $existingTrade = $user->trades('stocks')->create([
                'data_id' => $request['stock_id'],
                'type' => 'stocks',
                'amount' => ($request['quantity'] * $request['amount']),
                'quantity' => $request['quantity'],
                'symbol' => $request['stock_symbol'],
                'purchase_amount' => $request['amount'],
            ]);
        }

        // Create trade transaction record for the buy trade
        $existingTrade->tradeTransaction()->create([
            'quantity' => $request['quantity'],
            'amount' => $amount,
            'type' => 'buy',
            'profit' => 0,
        ]);

        return $existingTrade;
    }

    //::::: closeTrade has replaced it ::::://
    private function handleSellTrade($request, $stockAmount)
    {
        $user = auth()->user();
        $existingTrade = $user->trades('stocks')->where('data_id', $request['stock_id'])->first();

        $stock = Stock::find($request['stock_id']); // Fetch stock data

        if ($existingTrade) {
            if ($existingTrade->quantity >= $request['quantity']) {
                $existingTrade->decrement('quantity', $request['quantity']);

                if ($existingTrade->quantity == 0) {
                    $existingTrade->delete();
                }

                // Calculate profit for the sell trade
                $profit = ($request['quantity'] * $stock->price) - ($existingTrade->amount); //this is wrong

                // Create an asset transaction record for the sell trade
                $existingTrade->tradeTransaction()->create([
                    'quantity' => $request['quantity'],
                    'amount' => $stockAmount,
                    'type' => 'sell',
                    'profit' => $profit,
                ]);

                return $existingTrade;
            }

            return null; // Insufficient quantity to sell
        }

        return null; // No existing trade to sell
    }
    //::::: closeTrade has replaced it ::::://

    public function asset()
    {
        $user = auth()->user();
        $assets = $user->trades('stocks')->latest()->get();
        $balance = $user->wallet->trade;

        // Calculate the total amount of all trades
        $totalStocks = $user->trades('stocks')->sum('amount');

        $watchlistData = $user->watchlist()->where('type', 'crypto')->pluck('data_id');
        $watchlist = Stock::whereIn('id', $watchlistData)->get();

        $totalInvestment = 0;
        $totalCurrentValue = 0;
        $totalQuantity = 0;

        $stocks = $user->trades('stocks')->with('stock')->get();

        foreach ($stocks as $stock) {
            $investmentAmount = $stock->purchase_amount * $stock->quantity;
            $currentValue = $stock->stock['price'] * $stock->quantity;

            $currentQuantity = $stock->quantity;

            $totalInvestment += $investmentAmount;
            $totalCurrentValue += $currentValue;
            $totalQuantity += $currentQuantity;
        }

        $totalProfit = $totalCurrentValue - $totalInvestment;
        $percentageDifference = ($totalInvestment > 0) 
            ? ($totalProfit / $totalInvestment) * 100 
            : 0;
        
        $equityBalance = $totalCurrentValue;
        $totalAssetQuantity = $totalQuantity;

        if($totalStocks > 1)
            $equityBalancePercent = ($totalProfit / $totalStocks * 100);
        else 
            $equityBalancePercent = 0;

        return view('user_.trade.asset', [
            'title' => 'Trading',
            'assetNumber' => $user->trades('stocks')->count(),
            'assets' => $assets,
            'balance' => $balance,
            'totalAmount' => $totalStocks,
            'watchList' => $watchlist,

            'equityBalance' => $equityBalance,
            'equityBalancePercent' => $equityBalancePercent,
            'totalProfit' => $totalProfit,
            'totalInvestment' => $totalCurrentValue,
            'percentageDifference' => $percentageDifference,
            'totalAssetQuantity' => $totalAssetQuantity
        ]);
    }
    
    public function show (Stock $stock)
    {
        $user = auth()->user();

        $assets = $user->trades('stocks')->where('symbol', $stock->symbol)->get();

        $transactions = $user->trades('stocks')->where('symbol', $stock->symbol)->first();

        if($transactions) {
            $transaction = $transactions->tradeTransaction()->get();

            // Initialize variables for overall P/L
            $totalCost = 0;
            $totalRevenue = 0;

            foreach ($transaction as $asset) {
                $totalCost += $asset->amount; 
                $totalRevenue += $stock->price * $asset->quantity;
            }

            $ownAsset = $transactions;
            $amount = $transaction->where('type', 'buy')->sum('amount');
            $quantity = $transaction->where('type', 'buy')->sum('quantity');
            $profit = $ownAsset ? $ownAsset->amount : 0;

            // Calculate overall profit/loss
            $overallProfitLoss = ($transaction->where('type', 'buy')->sum('amount') - ($transaction->where('type', 'buy')->sum('quantity') * $stock->price));
            $percentageOverallProfitLoss = $amount > 0 ? ($overallProfitLoss / $amount) * 100 : 0;
        } else {
            $ownAsset = $transactions;
            $amount = 0;
            $quantity = 0;
            $profit = 0;

            // Calculate overall profit/loss
            $overallProfitLoss = 0;
            $percentageOverallProfitLoss = 0;
        }

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

    public function showAsset(Stock $stock)
    {
        $user = auth()->user();

        $assets = $user->trades('stocks')->where('symbol', $stock->symbol)->get();

        $transactions = $user->trades('stocks')->where('symbol', $stock->symbol)->first();

        if ($assets->count() <= 0) {
            return redirect()->route('assets')->with('info', "You don't have any holdings on " . $stock->name);
        }

        $transaction = $transactions->tradeTransaction()->get();

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($transaction as $asset) {
            $totalCost += $asset->amount; 
            $totalRevenue += $stock->price * $asset->quantity;
        }

        $ownAsset = $transactions;
        $amount = $transaction->where('type', 'buy')->sum('amount');
        $quantity = $transaction->where('type', 'buy')->sum('quantity');
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = (($transaction->where('type', 'buy')->sum('quantity') * $stock->price) - $transaction->where('type', 'buy')->sum('amount'));
        $percentageOverallProfitLoss = $amount > 0 ? ($overallProfitLoss / $amount) * 100 : 0;

        return view('user_.trade.show-asset', [
            'title' => 'My Asset',
            'asset' => $transaction,
            'stock' => $stock,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
            'trade' => $transactions,
        ]);
    }

    public function closeAllTrades(Trade $trade)
    {
        $user = auth()->user();

        $stock = $trade->stock()->first();

        $profitAmount = $stock->price * $trade->quantity;

        try {
            Ledger::credit($user->wallet, $profitAmount, 'trade', null, 'Trade stocks sell...');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error crediting wallet: ' . $e->getMessage());
        }

        $trade->delete();

        return redirect()->route('assets')->with('success', "All trades closed successfully.");
    }

    public function closeTrade(TradeTransaction $tradeTransaction)
    {
        $user = auth()->user();

        $trade = Trade::where('id', $tradeTransaction->trade_id)->first();

        $stock = $trade->stock()->first();

        $profitAmount = $stock->price * $tradeTransaction->quantity;


        if($tradeTransaction->quantity <= $trade->quantity) {
            $trade->decrement('quantity', $tradeTransaction->quantity);

            if ($trade->quantity == 0) {
                $trade->delete();
            }

            // $user->updateWalletBalance('trading', $profitAmount, 'increment');

            try {
                Ledger::credit($user->wallet, $profitAmount, 'trade', null, 'Trade stocks sell...');
            } catch (InvalidArgumentException $e) {
                return back()->with('error', 'Error crediting wallet: ' . $e->getMessage());
            }

            $tradeTransaction->update([
                'type' => 'sell',
                'updated_at' => now(), 
            ]);

            return redirect()->back()->with('success', 'Trade closed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to close trade. Insufficient quantity.');
    }
    //:::: STOCKS CONTROLLER :::://








    //:::: CRYPTO CONTROLLER :::://

    public function crypto(Request $request)
    {
        $user = auth()->user();

        // Start with a base query for the stocks (crypto assets)
        $query = Crypto::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('symbol', 'like', '%' . $searchTerm . '%');
            });
        }

        $stock = $query->paginate(40);
        $balance = auth()->user()->wallet->trade;

        $tradeCount = $user->trades('crypto')->count();

        $totalStocks = $user->trades('crypto')->sum('amount');

        $slidesData = $this->getTopCrypto();

        return view('user_.crypto.index', [
            'title' => 'Trading', 
            'stocks' => $stock, 
            'balance' => $balance, 
            'tradeCount' => $tradeCount,
            'totalStocks' => $totalStocks,

            'buyAmount' => 0,
            'buyTrade' => 0,
            'sellAmount' => 0,
            'sellTrade' => 0,

            'slidesData' => $slidesData,
        ]);
    }

    private function getTopCrypto()
    {
        // Fetch top 10 Stocks
        $stocks = Crypto::orderBy('id', 'asc')
            ->take(10)
            ->get();

        // Merge the cryptos and stocks into one collection (in this case, it's just stocks)
        $assets = $stocks;

        // Define the color classes
        $colors = ['success', 'primary', 'secondary', 'info', 'warning', 'danger', 'dark'];

        // Iterate over assets and assign random colors and img
        $assets = $assets->map(function ($asset) use ($colors) {
            // Shuffle the color array to get a random color each time
            $shuffledColors = $colors;
            shuffle($shuffledColors); // Shuffle the array

            return [
                'name' => $asset->name,
                'icon' => $asset->img,  // Use asset's img as the icon
                'colorClass' => $shuffledColors[0], // Randomly assigned color
                'price' => "$" . number_format($asset->price, 2), // Formatting price
                'percentageChange' => number_format($asset->changes_percentage, 2) . "%",
                'changeDirection' => "ti-arrow-bear-right", // You can replace with actual direction logic
                'changeAmount' => "$" . number_format($asset->change, 2),
            ];
        });

        // Shuffle the assets array to mix stocks randomly
        return $assets->shuffle(); // Return the shuffled assets directly as an array
    }


    public function storeCrypto(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'crypto_id' => ['required'],
            'crypto_symbol' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required'],
            'lots' => ['required', 'numeric', 'min:0.00001'],
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $user = auth()->user();

        // Retrieve the stock data
        $stock = Crypto::all()->where('id', $request['crypto_id'])->first();

        $amount = ($request['amount'] * $request['lots']);

        $stockAmount = ($request['lots'] * $stock->price);

        // Check if the stock is tradeable
        if ($stock->tradeable == 0) {
            return back()->with('error', 'Trading ' . $stock->name . ' is currently unavailable, check back later');
        }

        $trade = null;

        // Process the trade based on the type (buy/sell)
        if ($request['type'] == 'buy') {
            // Check for sufficient balance
            if (!$user->inSufficientBalance($amount, 'trading')) {
                return back()->withInput()->with('error', 'Insufficient trading balance');
            } else {
                // Handle buy trade
                $trade = $this->handleBuyCrypto($request, $amount);

                // ::::: Store Ledger :::::: //
                try {
                    Ledger::debit($user->wallet, $amount, 'trade', null, 'Trade stocks...');
                } catch (InvalidArgumentException $e) {
                    return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
                }
                // ::::: Store Ledger :::::: //
            }
        } elseif ($request['type'] == 'sell') {
            // Handle sell trade
            $trade = $this->handleSellCrypto($request, $stockAmount);
            if (!$trade) {
                return back()->with('error', 'Error processing sell trade');
            }
        }

        // Create a trading transaction
        $transaction = $user->transaction('trade')->create([
            'type' => 'trade',
            'amount' => $amount,
            'data_id' => $trade->id,
            'status' => 'approved',
            'description' => 'Crypto trade on ' . $stock->name
        ]);

        // Set the success message
        if ($request['type'] == 'sell') {
            $msg = 'Sold out ' . $request['quantity'] . ' of ' . $stock['name'] . ' $' . ($request['amount'] * $request['lots']) . 'successfully';
        } else {
            $msg = 'Purchase of ' . $request['quantity'] . ' ' . $stock['name'] . ' $' . ($request['amount'] * $request['lots']) . ' was successful';
        }
    
        // Store the savings transaction and redirect
        if ($transaction) {
            NotificationController::sendTradeNotification($trade, 'crypto', $request['type']);
            return redirect()->route('crypto.assets')->with('success', $msg);
        }

        // Handle any other errors
        return back()->withInput()->with('error', 'Error processing investment');
    }

    private function handleBuyCrypto($request, $amount)
    {
        $user = auth()->user();

        $existingTrade = $user->trades('crypto')->where('data_id', $request['crypto_id'])->first();
        
        if ($existingTrade) {
            $existingTrade->increment('quantity', $request['lots']);
            $existingTrade->increment('amount', $request['lots'] * $request['amount']);
        } else {
            $existingTrade = $user->trades('crypto')->create([
                'data_id' => $request['crypto_id'],
                'type' => 'crypto',
                'amount' => ($request['lots'] * $request['amount']),
                'quantity' => $request['lots'],
                'symbol' => $request['crypto_symbol'],
                'purchase_amount' => $request['amount'],
            ]);
        }

        // Create trade transaction record for the buy trade
        $existingTrade->tradeTransaction()->create([
            'quantity' => $request['lots'],
            'amount' => $amount,
            'type' => 'buy',
            'profit' => 0,
        ]);

        return $existingTrade;
    }

    //Warning: FIX SELL
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

        $user = auth()->user();

        // Check if the cryptocurrency is tradeable
        if ($crypto->tradeable == 0) {
            return back()->with('error', 'Trading ' . $crypto->name . ' is currently unavailable, check back later');
        }

        $existingTrade = $user->trades('crypto')->where('data_id', $request['crypto_id'])->first();
        
        $crypto = Crypto::find($request['crypto_id']); // Fetch crypto data

        // dd($existingTrade);

        if ($existingTrade) {
            if ($existingTrade->quantity >= $request['lots']) {
                $existingTrade->decrement('quantity', $request['lots']);

                $transaction = TradeTransaction::find($request['trans_id']);

                if($transaction->quantity <= 0.000001 && $existingTrade->amount < 1) {
                    $transaction->delete();
                } else {
                    if($transaction->quantity >= 0 & ($request['lots'] * $crypto->price) >= 0)
                        $transaction->decrement('quantity', $request['lots']);
                        $transaction->decrement('amount', ($request['lots'] * $crypto->price));
                }

                if($existingTrade->quantity <= 0 && $existingTrade->amount < 1) {
                    $transaction->delete();
                }

                // $user->updateWalletBalance('trading', $cryptoAmount, 'increment'); 

                try {
                    Ledger::credit($user->wallet, $cryptoAmount, 'trade', null, 'Trade stocks sell...');
                } catch (InvalidArgumentException $e) {
                    return back()->with('error', 'Error crediting wallet: ' . $e->getMessage());
                }

                // Calculate profit for the sell trade
                // $profit = ($request['lots'] * $crypto->price) - ($existingTrade->entry_price * $request['lots']);

                return $existingTrade;
            }

            return null; // Insufficient lots to sell
        }

        // // Create a trading transaction
        // $this->createTradingTransaction($existingTransaction, $amount, $request['type'], $crypto['name']);

        // // Set the success message
        // if ($request['type'] == 'sell') {
        //     $msg = 'Sold out ' . $request['quantity'] . ' of ' . $crypto['name'] . ' $' . ($request['amount'] * $request['quantity']) . 'successfully';
        // } else {
        //     $msg = 'Purchase of ' . $request['quantity'] . ' ' . $crypto['name'] . ' $' . ($request['amount'] * $request['quantity']) . ' was successful';
        // }
    
        // // Store the savings transaction and redirect
        // if ($existingTrade) {
        //     return redirect()->route('assets')->with('success', $msg);
        // }

        // // Handle any other errors
        // return back()->withInput()->with('error', 'Error processing investment');

        // return null; // No existing trade to sell
    }
    //Warning: FIX SELL

    public function cryptoAsset()
    {
        $user = auth()->user();
        $assets = $user->trades('crypto')->latest()->get();
        $balance = $user->wallet->trade;

        // Calculate the total amount of all trades
        $totalStocks = $user->trades('crypto')->sum('amount');

        $watchlistData = $user->watchlist()->where('type', 'crypto')->pluck('data_id');
        $watchlist = Crypto::whereIn('id', $watchlistData)->get();

        $totalInvestment = 0;
        $totalCurrentValue = 0;
        $totalQuantity = 0;

        $stocks = $user->trades('crypto')->with('crypto')->get();

        foreach ($stocks as $stock) {
            $investmentAmount = $stock->purchase_amount * $stock->quantity;
            $currentValue = $stock->crypto['price'] * $stock->quantity;

            $currentQuantity = $stock->quantity;

            $totalInvestment += $investmentAmount;
            $totalCurrentValue += $currentValue;
            $totalQuantity += $currentQuantity;
        }

        $totalProfit = $totalCurrentValue - $totalInvestment;
        $percentageDifference = ($totalInvestment > 0) 
            ? ($totalProfit / $totalInvestment) * 100 
            : 0;
        
        $equityBalance = $totalCurrentValue;
        $totalAssetQuantity = $totalQuantity;

        if($totalStocks > 1)
            $equityBalancePercent = ($totalProfit / $totalStocks * 100);
        else 
            $equityBalancePercent = 0;

        return view('user_.crypto.asset', [
            'title' => 'Trading',
            'assetNumber' => $user->trades('crypto')->count(),
            'assets' => $assets,
            'balance' => $balance,
            'totalAmount' => $totalStocks,
            'watchList' => $watchlist,

            'equityBalance' => $equityBalance,
            'equityBalancePercent' => $equityBalancePercent,
            'totalProfit' => $totalProfit,
            'totalInvestment' => $totalCurrentValue,
            'percentageDifference' => $percentageDifference,
            'totalAssetQuantity' => $totalAssetQuantity
        ]);
    }

    public function showCyptoTrade(Crypto $stock)
    {
        $user = auth()->user();

        $assets = $user->trades('crypto')->where('symbol', $stock->symbol)->get();

        $transactions = $user->trades('crypto')->where('symbol', $stock->symbol)->first();

        if ($assets->count() <= 0) {
            return redirect()->route('assets')->with('info', "You don't have any holdings on " . $stock->name);
        }

        $transaction = $transactions->tradeTransaction()->get();

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;

        foreach ($transaction as $asset) {
            $totalCost += $asset->amount; 
            $totalRevenue += $stock->price * $asset->quantity;
        }

        $ownAsset = $transactions;
        $amount = $transaction->where('type', 'buy')->sum('amount');
        $quantity = $transaction->where('type', 'buy')->sum('quantity');
        $profit = $ownAsset ? $ownAsset->amount : 0;

        // Calculate overall profit/loss
        $overallProfitLoss = ($transaction->where('type', 'buy')->sum('quantity') * $stock->price) - ($transaction->where('type', 'buy')->sum('amount'));
        $percentageOverallProfitLoss = $amount > 0 ? ($overallProfitLoss / $amount) * 100 : 0;

        return view('user_.crypto.view', [
            'title' => 'My Asset',
            'asset' => $transaction,
            'stock' => $stock,
            'amount' => $amount,
            'quantity' => $quantity,
            'profit' => $profit,
            'overallProfitLoss' => $overallProfitLoss,
            'percentageOverallProfitLoss' => $percentageOverallProfitLoss,
            'trade' => $transactions,
        ]);
    }

    public function closeAllAssets(Trade $trade)
    {
        $user = auth()->user();

        $stock = $trade->crypto()->first();

        $profitAmount = $stock->price * $trade->quantity;

        // $user->updateWalletBalance('trading', $profitAmount, 'increment');

        try {
            Ledger::credit($user->wallet, $profitAmount, 'trade', null, 'Trade stocks sell...');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error crediting wallet: ' . $e->getMessage());
        }

        $trade->delete();

        return redirect()->route('crypto.assets')->with('success', "All trades closed successfully.");
    }

    public function showCrypto (Crypto $stock)
    {
        $user = auth()->user();

        $assets = $user->trades('crypto')->where('symbol', $stock->symbol)->get();

        $transactions = $user->trades('crypto')->where('symbol', $stock->symbol)->first();

        if($transactions)
            $transaction = $transactions->tradeTransaction()->get();

        // Initialize variables for overall P/L
        $totalCost = 0;
        $totalRevenue = 0;
        
        if($transactions)
            foreach ($transaction as $asset) {
                $totalCost += $asset->amount; 
                $totalRevenue += $stock->price * $asset->quantity;
            }

        if($transactions) {
            $ownAsset = $transactions;
            $amount = $transaction->where('type', 'buy')->sum('amount');
            $quantity = $transaction->where('type', 'buy')->sum('quantity');
            $profit = $ownAsset ? $ownAsset->amount : 0;

            // Calculate overall profit/loss
            $overallProfitLoss = ($transaction->where('type', 'buy')->sum('amount') - ($transaction->where('type', 'buy')->sum('quantity') * $stock->price));
            $percentageOverallProfitLoss = $amount > 0 ? ($overallProfitLoss / $amount) * 100 : 0;
        } else {
            $amount = 0;
            $quantity = 0;
            $profit = 0;

            // Calculate overall profit/loss
            $overallProfitLoss = 0;
            $percentageOverallProfitLoss = 0;
        }

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

}
