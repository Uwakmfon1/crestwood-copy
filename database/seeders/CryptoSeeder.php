<?php

namespace Database\Seeders;

use App\Models\Crypto;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
        // // Step 1: Get the IDs of the first 300 records
        // $keepIds = DB::table('cryptos')
        //     ->orderBy('id') // Make sure to order by the 'id' or relevant column
        //     ->take(300)
        //     ->pluck('id')
        //     ->toArray();

        // // Step 2: Delete all records not in the $keepIds array
        // DB::table('cryptos')
        //     ->whereNotIn('id', $keepIds)
        //     ->delete();

        // // Optional: Output a message to confirm the operation
        // $this->command->info('Excess cryptocurrencies cleared, keeping only the first 300 records.');
        
    //     $faker = Faker::create();
    //     $apiKey = 'U16Gq0PRKGgnTbltSa5423seAWtQNV0T';

    //     // Step 1: Fetch stock data from API with retry logic
    //     $maxRetries = 3; // Maximum number of retries
    //     $attempt = 0;
    //     $response = null;

    //     while ($attempt < $maxRetries) {
    //         try {
    //             $response = Http::timeout(30)->get('https://financialmodelingprep.com/api/v3/stock/list?apikey=' . $apiKey);

    //             if ($response->successful()) {
    //                 break; // Exit loop if request is successful
    //             }
    //         } catch (RequestException $e) {
    //             Log::error("Request failed: " . $e->getMessage());
    //         }

    //         $attempt++;
    //         sleep(1); // Wait before retrying
    //     }

    //     if (!$response || !$response->successful()) {
    //         Log::error("Failed to fetch stock list after {$maxRetries} attempts. Response: " . ($response ? $response->body() : 'No response'));
    //         return; // Exit if request failed
    //     }

    //     $stocks = $response->json();

    //     // Prepare stocks data for fetching profiles
    //     $stockData = [];
    //     foreach ($stocks as $stock) {
    //         $stockData[] = [
    //             'symbol' => $stock['symbol'],
    //             'name' => $stock['name'],
    //             'exchange' => $stock['exchange'] ?? 'NASDAQ',
    //         ];
    //     }

    //     // Step 2: Fetch company profiles for all stocks
    //     $symbolsString = implode(',', array_column($stockData, 'symbol'));
    //     $profileResponse = Http::timeout(30)->get("https://financialmodelingprep.com/api/v3/profile/{$symbolsString}?apikey={$apiKey}");

    //     // Check if profile response is successful
    //     if ($profileResponse->successful()) {
    //         $profiles = $profileResponse->json();

    //         // Step 3: Prepare data for bulk upsert
    //         $upsertData = [];
    //         foreach ($profiles as $profile) {
    //             $symbol = strtoupper($profile['symbol']);
    //             $upsertData[] = [
    //                 'symbol' => $symbol,
    //                 'name' => $profile['companyName'] ?? null,
    //                 'img' => $profile['image'] ?? null,
    //                 'price' => $faker->randomFloat(2, 100, 500),
    //                 'changes_percentage' => $faker->randomFloat(4, -5, 5),
    //                 'change' => $faker->randomFloat(2, -10, 10),
    //                 'day_low' => $faker->randomFloat(2, 100, 400),
    //                 'day_high' => $faker->randomFloat(2, 100, 400),
    //                 'year_low' => $faker->randomFloat(2, 50, 200),
    //                 'year_high' => $faker->randomFloat(2, 200, 600),
    //                 'market_cap' => $faker->numberBetween(1000000000, 1000000000000),
    //                 'price_avg_50' => $faker->randomFloat(4, 100, 500),
    //                 'price_avg_200' => $faker->randomFloat(4, 100, 500),
    //                 'exchange' => $stockData[array_search($symbol, array_column($stockData, 'symbol'))]['exchange'],
    //                 'volume' => $faker->numberBetween(1000000, 100000000),
    //                 'avg_volume' => $faker->numberBetween(1000000, 100000000),
    //                 'open' => $faker->randomFloat(2, 100, 500),
    //                 'previous_close' => $faker->randomFloat(2, 100, 500),
    //                 'eps' => $faker->randomFloat(2, 1, 10),
    //                 'pe' => $faker->randomFloat(2, 10, 50),
    //                 'status' => $faker->randomElement(['active', 'inactive']),
    //                 'tradeable' => 1,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }

    //         // Step 4: Bulk upsert into the database
    //         Crypto::upsert($upsertData, ['symbol'], [
    //             'name', 'img', 'price', 'changes_percentage', 'change', 
    //             'day_low', 'day_high', 'year_low', 'year_high', 
    //             'market_cap', 'price_avg_50', 'price_avg_200', 
    //             'exchange', 'volume', 'avg_volume', 'open', 
    //             'previous_close', 'eps', 'pe', 'status', 
    //             'tradeable', 'updated_at'
    //         ]);
    //     } else {
    //         Log::error("Failed to fetch profiles. Response: " . $profileResponse->body());
    //     }
    // }





    public function run(): void
    {

        // $symbols = [
        //     // Stocks
        //     'AAPL', 'MSFT', 'GOOGL', 'AMZN', 'NVDA', 'META', 'TSLA', 'BRK.B', 'V', 'JNJ',
        //     'WMT', 'PG', 'JPM', 'UNH', 'MA', 'XOM', 'LLY', 'HD', 'CVX', 'MRK',
        //     'ABBV', 'PEP', 'KO', 'COST', 'AVGO', 'PFE', 'TMO', 'NKE', 'MCD', 'DIS',
        //     'CSCO', 'ACN', 'VZ', 'DHR', 'ADBE', 'CMCSA', 'NFLX', 'TXN', 'NEE', 'CRM',
        //     'ABT', 'BMY', 'WFC', 'INTC', 'LIN', 'ORCL', 'UPS', 'PM', 'RTX', 'AMD',
            
        //     // Crypto (USD pairs)
        //     'BTCUSD', 'ETHUSD', 'XRPUSD', 'LTCUSD', 'BCHUSD', 'ADAUSD', 'DOGEUSD', 'DOTUSD', 'SOLUSD', 'BNBUSD',
        //     'AVAXUSD', 'MATICUSD', 'UNIUSD', 'LINKUSD', 'XLMUSD', 'TRXUSD', 'ETCUSD', 'FILUSD', 'ALGOUSD', 'VETUSD',
        //     'THETAUSD', 'ATOMUSD', 'ICPUSD', 'XMRUSD', 'EOSUSD', 'AAVEUSD', 'MKRUSD', 'SUSHIUSD', 'COMPUSD', 'YFIUSD',
        //     'ZECUSD', 'DASHUSD', 'NEOUSD', 'QTUMUSD', 'WAVESUSD', 'ZILUSD', 'ONTUSD', 'NANOUSD', 'ICXUSD', 'BATUSD',
        //     'RENUSD', 'OMGUSD', 'ENJUSD', 'ANKRUSD', 'CHZUSD', 'KSMUSD', 'STXUSD', 'GRTUSD', 'SNXUSD', 'RUNEUSD'
        // ];

        $symbols = [
            // // Technology (50)
            // 'AAPL', 'MSFT', 'GOOGL', 'AMZN', 'NVDA', 'META', 'TSLA', 'AVGO', 'ASML', 'ADBE',
            // 'CSCO', 'ORCL', 'CRM', 'INTC', 'AMD', 'QCOM', 'TXN', 'IBM', 'NOW', 'SNOW',
            // 'PANW', 'UBER', 'NET', 'SHOP', 'CRWD', 'ZS', 'MDB', 'DDOG', 'TEAM', 'FTNT',
            // 'WDAY', 'ADSK', 'INTU', 'PYPL', 'SQ', 'DOCU', 'ZM', 'ROKU', 'SPLK', 'OKTA',
            // 'CDNS', 'ANSS', 'KLAC', 'LRCX', 'AMAT', 'MU', 'MRVL', 'ADI', 'NXPI', 'SWKS', 'PLTR',
        
            // // Financials (30)
            // 'JPM', 'BAC', 'WFC', 'C', 'GS', 'MS', 'SCHW', 'BLK', 'AXP', 'PYPL',
            // 'V', 'MA', 'DFS', 'COF', 'USB', 'TFC', 'PNC', 'BK', 'STT', 'ICE',
            // 'CME', 'SPGI', 'MCO', 'FIS', 'FISV', 'GPN', 'AJG', 'MMC', 'TW', 'NDAQ',
        
            // // Healthcare (30)
            // 'UNH', 'JNJ', 'PFE', 'ABBV', 'MRK', 'LLY', 'TMO', 'DHR', 'AMGN', 'GILD',
            // 'BMY', 'VRTX', 'REGN', 'ISRG', 'MDT', 'SYK', 'BDX', 'ZTS', 'CI', 'HUM',
            // 'ELV', 'CVS', 'ANTM', 'IQV', 'EW', 'IDXX', 'DXCM', 'BSX', 'HCA', 'MRNA',
        
            // // Consumer Discretionary (25)
            // 'HD', 'LOW', 'NKE', 'MCD', 'SBUX', 'TGT', 'COST', 'BKNG', 'MAR', 'HLT',
            // 'LVS', 'YUM', 'CMG', 'DPZ', 'NFLX', 'DIS', 'RCL', 'CCL', 'EXPE', 'ABNB',
            // 'DHI', 'LEN', 'NVR', 'PHM', 'TSCO',
        
            // // Industrials (25)
            // 'HON', 'GE', 'CAT', 'BA', 'RTX', 'LMT', 'GD', 'NOC', 'DE', 'UPS',
            // 'FDX', 'CSX', 'UNP', 'NSC', 'WM', 'RSG', 'WAB', 'EMR', 'ETN', 'ITW',
            // 'ROK', 'SWK', 'PH', 'DOV', 'AME',
        
            // // Consumer Staples (20)
            // 'PG', 'KO', 'PEP', 'WMT', 'COST', 'PM', 'MO', 'MDLZ', 'KHC', 'CL',
            // 'EL', 'GIS', 'KMB', 'SYY', 'HSY', 'ADM', 'STZ', 'BF.B', 'CPB', 'MNST',
        
            // // Energy (15)
            // 'XOM', 'CVX', 'COP', 'EOG', 'SLB', 'OXY', 'PSX', 'MPC', 'VLO', 'PXD',
            // 'HES', 'DVN', 'FANG', 'HAL', 'BKR',
        
            // // Utilities (10)
            // 'NEE', 'DUK', 'SO', 'D', 'AEP', 'EXC', 'SRE', 'PEG', 'ED', 'EIX',
        
            // // Real Estate (10)
            // 'AMT', 'PLD', 'CCI', 'EQIX', 'PSA', 'SBAC', 'DLR', 'WELL', 'AVB', 'O',
        
            // // Materials (10)
            // 'LIN', 'APD', 'SHW', 'FCX', 'NEM', 'DOW', 'ECL', 'PPG', 'VMC', 'NUE',
        
            // // Communication Services (15)
            // 'GOOG', 'GOOGL', 'META', 'DIS', 'NFLX', 'T', 'VZ', 'TMUS', 'CHTR', 'CMCSA',
            // 'EA', 'TTWO', 'ATVI', 'ROKU', 'ZG',
        
            // Top 50 by market cap
            'BTCUSD', 'ETHUSD', 'USDTUSD', 'BNBUSD', 'SOLUSD', 'XRPUSD', 'USDCUSD', 'ADAUSD', 'DOGEUSD', 'AVAXUSD',
            'SHIBUSD', 'DOTUSD', 'TRXUSD', 'LINKUSD', 'MATICUSD', 'WBTCUSD', 'TONUSD', 'ICPUSD', 'DAIUSD', 'LTCUSD',
            'BCHUSD', 'UNIUSD', 'ATOMUSD', 'XLMUSD', 'ETCUSD', 'INJUSD', 'XMRUSD', 'FILUSD', 'IMXUSD', 'APTUSD',
            'RNDRUSD', 'STXUSD', 'HBARUSD', 'CROUSD', 'NEARUSD', 'VETUSD', 'OPUSD', 'MKRUSD', 'GRTUSD', 'ARBUSD',
            'THETAUSD', 'FDUSD', 'PEPEUSD', 'KASUSD', 'RUNEUSD', 'FRAXUSD', 'AAVEUSD', 'ALGOUSD', 'FLOWUSD', 'EGLDUSD',
            
            // Next 50 (51-100)
            'QNTUSD', 'BSVUSD', 'XTZUSD', 'EOSUSD', 'MINAUSD', 'AXSUSD', 'SANDUSD', 'MANAUSD', 'NEOUSD', 'KCSUSD',
            'BTTUSD', 'CHZUSD', 'USDPUSD', 'SNXUSD', 'FTMUSD', 'BGBUSD', 'CRVUSD', 'GALAUSD', 'ROSEUSD', 'ZECUSD',
            'XECUSD', 'KAVAUSD', 'DASHUSD', 'PAXGUSD', 'IOTAUSD', 'WEMIXUSD', 'COMPUSD', 'HNTUSD', 'CAKEUSD', 'GMXUSD',
            'CFXUSD', 'TUSDUSD', 'BONKUSD', 'GTUSD', '1INCHUSD', 'LDOUSD', 'XDCUSD', 'FXSUSD', 'SUIUSD', 'APEUSD',
            'ENSUSD', 'AGIXUSD', 'RPLUSD', 'OCEANUSD', 'NEXOUSD', 'ZILUSD', 'KLAYUSD', 'GNOUSD', 'YFIUSD', 'WOOUSD',
            
            // // Next 50 (101-150)
            // 'CELOUSD', 'DYDXUSD', 'TFUELUSD', 'JSTUSD', 'IOTXUSD', 'ANKRUSD', 'ASTRUSD', 'GUSDUSD', 'SKLUSD', 'CSPRUSD',
            // 'BATUSD', 'GLMUSD', 'LSKUSD', 'AUDIOUSD', 'RVNUSD', 'SUSHIUSD', 'ICXUSD', 'STORJUSD', 'ONTUSD', 'ZRXUSD',
            // 'SSVUSD', 'UMAUSD', 'WAVESUSD', 'CKBUSD', 'SCUSD', 'FETUSD', 'LRCUSD', 'TWTUSD', 'DCRUSD', 'API3USD',
            // 'BALUSD', 'GLMRUSD', 'SXPUSD', 'NMRUSD', 'COTIUSD', 'CTSIUSD', 'BANDUSD', 'OXTUSD', 'HOTUSD', 'QTUMUSD',
            // 'POWRUSD', 'DGBUSD', 'KSMUSD', 'XEMUSD', 'FLRUSD', 'YGGUSD', 'JASMYUSD', 'ACHUSD', 'RLCUSD', 'MDTUSD',
            
            // // Next 50 (151-200)
            // 'STRAXUSD', 'SYSUSD', 'CVCUSD', 'REQUSD', 'POLYXUSD', 'STEEMUSD', 'WAXPUSD', 'ARUSD', 'DENTUSD', 'CELRUSD',
            // 'VTHOUSD', 'UOSUSD', 'MTLUSD', 'PERPUSD', 'ONGUSD', 'CHRUSD', 'ILVUSD', 'SFPUSD', 'HIVEUSD', 'ORBSUSD',
            // 'PEOPLEUSD', 'DUSKUSD', 'RAYUSD', 'SLPUSD', 'PUNDIXUSD', 'CEEKUSD', 'METISUSD', 'NKNUSD', 'MASKUSD', 'ATAUSD',
            // 'GALUSD', 'LPTUSD', 'AMBUSD', 'RIFUSD', 'ADXUSD', 'OASUSD', 'DIAUSD', 'IQUSD', 'AGLDUSD', 'ERNUSD',
            // 'PHAUSD', 'FLOKIUSD', 'MOVRUSD', 'TUSD', 'CFGUSD', 'AERGOUSD', 'BICOUSD', 'TRUUSD', 'MXCUSD', 'ALPHAUSD',
            
            // Next 50 (201-250)
            'AIOZUSD', 'MBOXUSD', 'AURORAUSD', 'SUNUSD', 'RDNTUSD', 'BELUSD', 'RADUSD', 'CTXCUSD', 'VRAUSD', 'BUSD',
            'HIGHUSD', 'EDENUSD', 'FIDAUSD', 'TLMUSD', 'QUICKUSD', 'XNOUSD', 'AKTUSD', 'MLNUSD', 'REPUSD', 'ASTUSD',
            'BTRSTUSD', 'GHSTUSD', 'MNGOUSD', 'RAREUSD', 'PROUSD', 'OUSD', 'LCXUSD', 'FARMUSD', 'POLSUSD', 'ALICEUSD',
            'FORTHUSD', 'KP3RUSD', 'BADGERUSD', 'BONDUSD', 'TRBUSD', 'IDEXUSD', 'TRIBEUSD', 'GTCUSD', 'MIRUSD', 'ASMUSD',
            'CLVUSD', 'DFIUSD', 'FUNUSD', 'GUSD', 'MULTIUSD', 'NESTUSD', 'PLAUSD', 'PROMUSD', 'SUKUUSD', 'VELOUSD'
        ];
        
        $apiKey = env('ASSET_KEY');;
        $batchSize = 100;
        
        // Process symbols in batches with their types
        $symbolTypes = [
            'stocks' => array_filter($symbols, fn($s) => !str_ends_with($s, 'USD')),
            'crypto' => array_filter($symbols, fn($s) => str_ends_with($s, 'USD'))
        ];
        
        foreach ($symbolTypes as $type => $symbolsOfType) {
            if (empty($symbolsOfType)) continue;
            
            $chunks = array_chunk($symbolsOfType, $batchSize);
            
            foreach ($chunks as $chunk) {
                $symbolsString = implode(',', $chunk);
                $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$symbolsString}?apikey={$apiKey}";
        
                try {
                    $response = Http::get($apiUrl);
                    
                    if ($response->failed()) {
                        $this->command->error("Failed to fetch {$type} data for: {$symbolsString}");
                        continue;
                    }
        
                    $assets = $response->json();
                    if (empty($assets)) {
                        $this->command->warn("No {$type} data returned for: {$symbolsString}");
                        continue;
                    }
        
                    $assetsData = array_map(function ($asset) use ($type) {
                        return [
                            'symbol' => $asset['symbol'],
                            'name' => $asset['name'],
                            'img' => "https://images.financialmodelingprep.com/symbol/{$asset['symbol']}.png",
                            'price' => $asset['price'],
                            'changes_percentage' => $asset['changesPercentage'],
                            'change' => $asset['change'],
                            'day_low' => $asset['dayLow'],
                            'day_high' => $asset['dayHigh'],
                            'year_low' => $asset['yearLow'],
                            'year_high' => $asset['yearHigh'],
                            'market_cap' => $asset['marketCap'],
                            'price_avg_50' => $asset['priceAvg50'],
                            'price_avg_200' => $asset['priceAvg200'],
                            'exchange' => $asset['exchange'],
                            'volume' => $asset['volume'] ?? 0,
                            'avg_volume' => $asset['avgVolume'] ?? 0,
                            'open' => $asset['open'] ?? 0,
                            'previous_close' => $asset['previousClose'] ?? 0,
                            'eps' => $asset['eps'] ?? 0,
                            'pe' => $asset['pe'] ?? 0,
                            'type' => $type,  // Dynamic type assignment
                            'status' => 'active',
                            'tradeable' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }, $assets);
        
                    DB::table('cryptos')->upsert($assetsData, ['symbol'], array_keys($assetsData[0]));
                    $this->command->info("Successfully processed {$type} batch: {$symbolsString}");
                    
                } catch (\Exception $e) {
                    $this->command->error("Error processing {$type} symbols: {$symbolsString} - {$e->getMessage()}");
                    Log::error("Error in {$type} seeder", ['symbols' => $symbolsString, 'error' => $e->getMessage()]);
                }
            }
        }
        
        $this->command->info("Asset seeding completed for all types.");

    }



}
