<?php

namespace Database\Seeders;

use App\Models\Stock;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     $symbols = [
    //         'AAPL', 'MSFT', 'GOOGL', 'AMZN', 'NVDA', 'META', 'TSLA', 'BRK.B', 'V', 'JNJ',
    //         'WMT', 'PG', 'JPM', 'UNH', 'MA', 'XOM', 'LLY', 'HD', 'CVX', 'MRK',
    //         'ABBV', 'PEP', 'KO', 'COST', 'AVGO', 'PFE', 'TMO', 'NKE', 'MCD', 'DIS',
    //         'CSCO', 'ACN', 'VZ', 'DHR', 'ADBE', 'CMCSA', 'NFLX', 'TXN', 'NEE', 'CRM',
    //         'ABT', 'BMY', 'WFC', 'INTC', 'LIN', 'ORCL', 'UPS', 'PM', 'RTX', 'AMD',
    //         'SBUX', 'HON', 'CVS', 'LOW', 'IBM', 'QCOM', 'UNP', 'MS', 'INTU', 'SPGI',
    //         'MDT', 'SCHW', 'GS', 'BLK', 'T', 'PLD', 'BKNG', 'ADP', 'CAT', 'ELV',
    //         'ISRG', 'NOW', 'MU', 'DE', 'LMT', 'AXP', 'GILD', 'SYK', 'ZTS', 'USB',
    //         'TGT', 'AMAT', 'GE', 'MMC', 'ADI', 'MDLZ', 'MO', 'ADSK', 'PNC', 'CI',
    //         'EW', 'ITW', 'MRNA', 'CB', 'C', 'CL', 'BA', 'CSX', 'HUM', 'DUK',
    //         'MNST', 'BDX', 'BSX', 'NSC', 'AON', 'FIS', 'VRTX', 'PGR', 'GM', 'FDX',
    //         'APD', 'EMR', 'SHW', 'KMB', 'ECL', 'CHTR', 'REGN', 'ETN', 'AEP', 'COF',
    //         'DAL', 'AIG', 'WBA', 'EA', 'SLB', 'STZ', 'BIIB', 'TT', 'PRU', 'CTSH',
    //         'MPC', 'LRCX', 'HCA', 'TRV', 'PSA', 'AFL', 'VLO', 'SRE', 'LUV', 'D',
    //         'COO', 'KMI', 'HLT', 'KHC', 'XEL', 'PEG', 'ED', 'DTE', 'SO', 'AEE',
    //         'WEC', 'AWK', 'EIX', 'CMS', 'OKE', 'PCG', 'NI', 'AES', 'ATO', 'ESS',
    //         'ARE', 'AMT', 'SBAC', 'CCI', 'EXR', 'BXP', 'BAM', 'NTRS', 'ICE', 'VTR',
    //         'FISV', 'MCO', 'DHI', 'PSX', 'MCHP', 'RF', 'TSCO', 'K', 'CNP', 'AMP',
    //         'SYY', 'CERN', 'GLW', 'NUE', 'MOS', 'LYB', 'ROK', 'KEY', 'HIG', 'HPE',
    //         'ADM', 'CAG', 'WDC', 'IP', 'F', 'WY', 'LEN', 'PPL', 'HES', 'IPG',
    //         'MTD', 'RHI', 'FTV', 'CINF', 'OMC', 'MKC', 'LKQ', 'HPQ', 'ZBH', 'AVB',
    //         'RCL', 'CPB', 'SJM', 'IRM', 'CLX', 'VFC', 'BBY', 'DGX', 'APA', 'CMA',
    //         'BKR', 'TXT', 'PH', 'URI', 'RJF', 'HRL', 'SEE', 'ETR', 'RSG', 'RMD',
    //         'CTAS', 'PAYX', 'LDOS', 'TROW', 'DG', 'BBWI', 'LVS', 'BWA', 'AAP', 'MKTX',
    //         'NVR', 'AZO', 'MTCH', 'FMC', 'WRB', 'GPC', 'EXPD', 'AAL', 'MAS', 'FDS',
    //         'HST', 'DOV', 'HAS', 'ROL', 'SNA', 'XYL', 'NDAQ', 'DRI', 'IFF', 'NWL',
    //         'PKG', 'CHD', 'GL', 'MCK', 'SWK', 'TEL', 'NCLH', 'DISH', 'LNT', 'ANET',
    //         'ALLE', 'WAT', 'CBOE', 'PFG', 'AOS', 'TYL', 'JKHY', 'UHS', 'VMC', 'GRMN',
    //         'CDW', 'AKAM', 'TECH', 'HOLX', 'MHK', 'HSY', 'MLM', 'MOH', 'NDSN', 'RE',
    //         'CHRW', 'BF.B', 'PNW', 'MKL', 'WHR', 'TRMB', 'L', 'NEM', 'NOV', 'FTNT',
    //         'DXCM', 'ABMD', 'VRSK', 'ZBRA', 'CDNS', 'IDXX', 'TTC', 'SWKS', 'CHTR',
    //         'SNPS', 'QRVO', 'NOW', 'POOL', 'CTLT', 'ALB', 'CNC', 'ALXN', 'BLL',
    //         'RCL', 'AJG', 'TAP', 'ODFL', 'WRK', 'CRL', 'NWSA', 'XRAY', 'CERN', 'ALLE',
    //         'DRE', 'CF', 'HRB', 'NRG', 'JBHT', 'TPR', 'LDOS', 'JWN', 'WOOF', 'CPRT',
    //         'LUMN', 'FOXA', 'CPRI', 'RIG', 'JBL', 'PENN', 'CCL', 'MOS', 'FL', 'BEN',
    //         'GWW', 'IT', 'UNM', 'LNC', 'COHR', 'IRM', 'DVA', 'FRC', 'ROL', 'UAA',
    //         'UDR', 'GNRC', 'SBH', 'DXC', 'LKQ', 'TSN', 'JNPR', 'CHH', 'HBI', 'TDC'
    //     ];

    //     $apiKey = 'ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';

    //     // Batch size
    //     $batchSize = 100;
    //     $symbolChunks = array_chunk($symbols, $batchSize);

    //     foreach ($symbolChunks as $chunk) {
    //         $symbolsString = implode(',', $chunk);
    //         $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$symbolsString}?apikey={$apiKey}";

    //         // Fetch data from the API
    //         $response = Http::get($apiUrl);

    //         if ($response->failed()) {
    //             $this->command->error("Failed to fetch data from API for batch: {$symbolsString}");
    //             continue;
    //         }

    //         $stocks = $response->json();

    //         if (empty($stocks)) {
    //             $this->command->warn("No data received for batch: {$symbolsString}");
    //             continue;
    //         }

    //         foreach ($stocks as $stockData) {
    //             try {
    //                 DB::table('stocks')->updateOrInsert(
    //                     ['symbol' => $stockData['symbol']],
    //                     [
    //                         'name' => $stockData['name'],
    //                         'img' => "https://images.financialmodelingprep.com/symbol/{$stockData['symbol']}.png",
    //                         'price' => $stockData['price'],
    //                         'changes_percentage' => $stockData['changesPercentage'],
    //                         'change' => $stockData['change'],
    //                         'day_low' => $stockData['dayLow'],
    //                         'day_high' => $stockData['dayHigh'],
    //                         'year_low' => $stockData['yearLow'],
    //                         'year_high' => $stockData['yearHigh'],
    //                         'market_cap' => $stockData['marketCap'],
    //                         'price_avg_50' => $stockData['priceAvg50'],
    //                         'price_avg_200' => $stockData['priceAvg200'],
    //                         'exchange' => $stockData['exchange'],
    //                         'volume' => $stockData['volume'],
    //                         'avg_volume' => $stockData['avgVolume'],
    //                         'open' => $stockData['open'],
    //                         'previous_close' => $stockData['previousClose'],
    //                         'eps' => $stockData['eps'],
    //                         'pe' => $stockData['pe'],
    //                         'status' => 'active',
    //                         'tradeable' => 1,
    //                         'created_at' => now(),
    //                         'updated_at' => now(),
    //                     ]
    //                 );
                    
    //                 $this->command->info("Successfully inserted/updated stock: {$stockData['symbol']}");
    //             } catch (\Exception $e) {
    //                 $this->command->error("Failed to insert/update stock: {$stockData['symbol']} - " . $e->getMessage());
    //                 Log::error("Failed to insert/update stock: {$stockData['symbol']}", ['error' => $e->getMessage()]);
    //             }
    //         }
    //     }

    //     $this->command->info("Stock seeding completed.");
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
            // Technology (50)
            'AAPL', 'MSFT', 'GOOGL', 'AMZN', 'NVDA', 'META', 'TSLA', 'AVGO', 'ASML', 'ADBE',
            'CSCO', 'ORCL', 'CRM', 'INTC', 'AMD', 'QCOM', 'TXN', 'IBM', 'NOW', 'SNOW',
            'PANW', 'UBER', 'NET', 'SHOP', 'CRWD', 'ZS', 'MDB', 'DDOG', 'TEAM', 'FTNT',
            'WDAY', 'ADSK', 'INTU', 'PYPL', 'SQ', 'DOCU', 'ZM', 'ROKU', 'SPLK', 'OKTA',
            'CDNS', 'ANSS', 'KLAC', 'LRCX', 'AMAT', 'MU', 'MRVL', 'ADI', 'NXPI', 'SWKS', 'PLTR',
        
            // Financials (30)
            'JPM', 'BAC', 'WFC', 'C', 'GS', 'MS', 'SCHW', 'BLK', 'AXP', 'PYPL',
            'V', 'MA', 'DFS', 'COF', 'USB', 'TFC', 'PNC', 'BK', 'STT', 'ICE',
            'CME', 'SPGI', 'MCO', 'FIS', 'FISV', 'GPN', 'AJG', 'MMC', 'TW', 'NDAQ',
        
            // Healthcare (30)
            'UNH', 'JNJ', 'PFE', 'ABBV', 'MRK', 'LLY', 'TMO', 'DHR', 'AMGN', 'GILD',
            'BMY', 'VRTX', 'REGN', 'ISRG', 'MDT', 'SYK', 'BDX', 'ZTS', 'CI', 'HUM',
            'ELV', 'CVS', 'ANTM', 'IQV', 'EW', 'IDXX', 'DXCM', 'BSX', 'HCA', 'MRNA',
        
            // Consumer Discretionary (25)
            'HD', 'LOW', 'NKE', 'MCD', 'SBUX', 'TGT', 'COST', 'BKNG', 'MAR', 'HLT',
            'LVS', 'YUM', 'CMG', 'DPZ', 'NFLX', 'DIS', 'RCL', 'CCL', 'EXPE', 'ABNB',
            'DHI', 'LEN', 'NVR', 'PHM', 'TSCO',
        
            // Industrials (25)
            'HON', 'GE', 'CAT', 'BA', 'RTX', 'LMT', 'GD', 'NOC', 'DE', 'UPS',
            'FDX', 'CSX', 'UNP', 'NSC', 'WM', 'RSG', 'WAB', 'EMR', 'ETN', 'ITW',
            'ROK', 'SWK', 'PH', 'DOV', 'AME',
        
            // Consumer Staples (20)
            'PG', 'KO', 'PEP', 'WMT', 'COST', 'PM', 'MO', 'MDLZ', 'KHC', 'CL',
            'EL', 'GIS', 'KMB', 'SYY', 'HSY', 'ADM', 'STZ', 'BF.B', 'CPB', 'MNST',
        
            // Energy (15)
            'XOM', 'CVX', 'COP', 'EOG', 'SLB', 'OXY', 'PSX', 'MPC', 'VLO', 'PXD',
            'HES', 'DVN', 'FANG', 'HAL', 'BKR',
        
            // Utilities (10)
            'NEE', 'DUK', 'SO', 'D', 'AEP', 'EXC', 'SRE', 'PEG', 'ED', 'EIX',
        
            // Real Estate (10)
            'AMT', 'PLD', 'CCI', 'EQIX', 'PSA', 'SBAC', 'DLR', 'WELL', 'AVB', 'O',
        
            // Materials (10)
            'LIN', 'APD', 'SHW', 'FCX', 'NEM', 'DOW', 'ECL', 'PPG', 'VMC', 'NUE',
        
            // Communication Services (15)
            'GOOG', 'GOOGL', 'META', 'DIS', 'NFLX', 'T', 'VZ', 'TMUS', 'CHTR', 'CMCSA',
            'EA', 'TTWO', 'ATVI', 'ROKU', 'ZG',
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
                            'status' => 'active',
                            'tradeable' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }, $assets);
        
                    DB::table('stocks')->upsert($assetsData, ['symbol'], array_keys($assetsData[0]));
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
