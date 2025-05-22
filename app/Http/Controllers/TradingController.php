<?php

namespace App\Http\Controllers;


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
use App\Services\TradingService;
use App\Models\TradeTransaction;
use App\Models\CryptoTransaction;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;

class TradingController extends Controller
{
    public function __construct(public TradingService $tradingService) { }
   
    //:::: STOCKS CONTROLLER :::://

    public function index(Request $request){return $this->tradingService->index($request);}
  
    public function store(Request $request) {return $this->tradingService->store($request); }
  
    public function asset(){return $this->tradingService->asset();}
      
    public function show(Stock $stock){ return $this->tradingService->show($stock); }
  
    public function showAsset(Stock $stock){ return $this->tradingService->showAsset($stock);}
 
    public function closeAllTrades(Trade $trade){ return $this->tradingService->closeAllTrades($trade);}

    public function closeTrade(TradeTransaction $tradeTransaction){ return $this->tradingService->closeTrade($tradeTransaction); }
    //:::: STOCKS CONTROLLER :::://






    //:::: CRYPTO CONTROLLER :::://

    public function crypto(Request $request){ return $this->tradingService->crypto($request); }
  
    public function storeCrypto(Request $request) { return $this->tradingService->storeCrypto($request);}
   
    public function cryptoAsset(){ return $this->tradingService->cryptoAsset(); }
   
    public function showCryptoTrade(Crypto $stock) { return $this->tradingService->showCryptoTrade($stock); }
   
    public function closeAllAssets(Trade $trade){return $this->tradingService->closeAllAssets($trade); }
 
    public function showCrypto(Crypto $stock) { return $this->tradingService->showCrypto($stock);}

}
