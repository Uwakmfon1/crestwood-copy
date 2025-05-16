<?php

namespace App\Http\Controllers\API;

use App\Models\AccountCoin;
use Illuminate\Http\Request;
use App\Models\AccountAddress;
use App\Models\AccountNetwork;
use App\Http\Controllers\Controller;
use App\Services\API\WalletService;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function __construct(public WalletService $walletService)
    {
        
    }

    public function getBalance()
    {
        return $this->walletService->getBalance();
    }

    // public function getBalance(): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json(['data' => [
    //         'naira' => auth('api')->user()->nairaWallet()->first()['balance'],
    //         'gold' => round(auth('api')->user()->goldWallet()->first()['balance'], 6),
    //         'silver' => round(auth('api')->user()->silverWallet()->first()['balance'], 6),
    //     ]]);
    // }

    public function getPrice()
    {
        return $this->walletService->getPrice();
    }
    // public function getPrice()
    // {
    //     try {
    //         $response = Http::get('https://data.orionterminal.com/api/info', [
    //             'headers' => [
    //                 'Content-Type' => 'application/json',
    //             ],
    //         ]);
    
    //         if ($response->successful()) {
    //             $info = $response->json();
    //             // $exchanges = $info['EXCHANGES'];

    //             return $info;
    //             // Do something with $exchanges
    //         } else {
    //             throw new \Exception("HTTP error! Status: {$response->status()}");
    //         }
    //     } catch (\Exception $e) {
    //         // Handle error
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

     public function getCoin()
    {
        return $this->walletService->getCoin();
    }
    // public function getCoin()
    // {
    //     $coin = AccountCoin::latest()->get();
    //     return response()->json(['data' => $coin]);
    // }

    public function getNetworks($coinId)
    {
        return $this->walletService->getNetworks($coinId);
    }

    // public function getNetworks($coinId)
    // {
    //     $networks = AccountNetwork::where('account_coin_id', $coinId)->get();
    //     return response()->json(['data' => $networks]);
    // }

    public function getAddress($networkId)
    {
        return $this->walletService->getAddress($networkId);
    }

    // public function getAddress($networkId)
    // {
    //     $address = AccountAddress::where('account_network_id', $networkId)->first();
    //     return response()->json(['data' => $address]);
    // }


}
