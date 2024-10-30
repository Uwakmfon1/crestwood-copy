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
    public function run()
    {

        $symbols = [
            'AAPL', 'MSFT', 'GOOGL', 'AMZN', 'NVDA', 'META', 'TSLA', 'BRK.B', 'V', 'JNJ',
            'WMT', 'PG', 'JPM', 'UNH', 'MA', 'XOM', 'LLY', 'HD', 'CVX', 'MRK',
            'ABBV', 'PEP', 'KO', 'COST', 'AVGO', 'PFE', 'TMO', 'NKE', 'MCD', 'DIS',
            'CSCO', 'ACN', 'VZ', 'DHR', 'ADBE', 'CMCSA', 'NFLX', 'TXN', 'NEE', 'CRM',
            'ABT', 'BMY', 'WFC', 'INTC', 'LIN', 'ORCL', 'UPS', 'PM', 'RTX', 'AMD',
            'SBUX', 'HON', 'CVS', 'LOW', 'IBM', 'QCOM', 'UNP', 'MS', 'INTU', 'SPGI',
            'MDT', 'SCHW', 'GS', 'BLK', 'T', 'PLD', 'BKNG', 'ADP', 'CAT', 'ELV',
            'ISRG', 'NOW', 'MU', 'DE', 'LMT', 'AXP', 'GILD', 'SYK', 'ZTS', 'USB',
            'TGT', 'AMAT', 'GE', 'MMC', 'ADI', 'MDLZ', 'MO', 'ADSK', 'PNC', 'CI',
            'EW', 'ITW', 'MRNA', 'CB', 'C', 'CL', 'BA', 'CSX', 'HUM', 'DUK',
            'MNST', 'BDX', 'BSX', 'NSC', 'AON', 'FIS', 'VRTX', 'PGR', 'GM', 'FDX',
            'APD', 'EMR', 'SHW', 'KMB', 'ECL', 'CHTR', 'REGN', 'ETN', 'AEP', 'COF',
            'DAL', 'AIG', 'WBA', 'EA', 'SLB', 'STZ', 'BIIB', 'TT', 'PRU', 'CTSH',
            'MPC', 'LRCX', 'HCA', 'TRV', 'PSA', 'AFL', 'VLO', 'SRE', 'LUV', 'D',
            'COO', 'KMI', 'HLT', 'KHC', 'XEL', 'PEG', 'ED', 'DTE', 'SO', 'AEE',
            'WEC', 'AWK', 'EIX', 'CMS', 'OKE', 'PCG', 'NI', 'AES', 'ATO', 'ESS',
            'ARE', 'AMT', 'SBAC', 'CCI', 'EXR', 'BXP', 'BAM', 'NTRS', 'ICE', 'VTR',
            'FISV', 'MCO', 'DHI', 'PSX', 'MCHP', 'RF', 'TSCO', 'K', 'CNP', 'AMP',
            'SYY', 'CERN', 'GLW', 'NUE', 'MOS', 'LYB', 'ROK', 'KEY', 'HIG', 'HPE',
            'ADM', 'CAG', 'WDC', 'IP', 'F', 'WY', 'LEN', 'PPL', 'HES', 'IPG',
            'MTD', 'RHI', 'FTV', 'CINF', 'OMC', 'MKC', 'LKQ', 'HPQ', 'ZBH', 'AVB',
            'RCL', 'CPB', 'SJM', 'IRM', 'CLX', 'VFC', 'BBY', 'DGX', 'APA', 'CMA',
            'BKR', 'TXT', 'PH', 'URI', 'RJF', 'HRL', 'SEE', 'ETR', 'RSG', 'RMD',
            'CTAS', 'PAYX', 'LDOS', 'TROW', 'DG', 'BBWI', 'LVS', 'BWA', 'AAP', 'MKTX',
            'NVR', 'AZO', 'MTCH', 'FMC', 'WRB', 'GPC', 'EXPD', 'AAL', 'MAS', 'FDS',
            'HST', 'DOV', 'HAS', 'ROL', 'SNA', 'XYL', 'NDAQ', 'DRI', 'IFF', 'NWL',
            'PKG', 'CHD', 'GL', 'MCK', 'SWK', 'TEL', 'NCLH', 'DISH', 'LNT', 'ANET',
            'ALLE', 'WAT', 'CBOE', 'PFG', 'AOS', 'TYL', 'JKHY', 'UHS', 'VMC', 'GRMN',
            'CDW', 'AKAM', 'TECH', 'HOLX', 'MHK', 'HSY', 'MLM', 'MOH', 'NDSN', 'RE',
            'CHRW', 'BF.B', 'PNW', 'MKL', 'WHR', 'TRMB', 'L', 'NEM', 'NOV', 'FTNT',
            'DXCM', 'ABMD', 'VRSK', 'ZBRA', 'CDNS', 'IDXX', 'TTC', 'SWKS', 'CHTR',
            'SNPS', 'QRVO', 'NOW', 'POOL', 'CTLT', 'ALB', 'CNC', 'ALXN', 'BLL',
            'RCL', 'AJG', 'TAP', 'ODFL', 'WRK', 'CRL', 'NWSA', 'XRAY', 'CERN', 'ALLE',
            'DRE', 'CF', 'HRB', 'NRG', 'JBHT', 'TPR', 'LDOS', 'JWN', 'WOOF', 'CPRT',
            'LUMN', 'FOXA', 'CPRI', 'RIG', 'JBL', 'PENN', 'CCL', 'MOS', 'FL', 'BEN',
            'GWW', 'IT', 'UNM', 'LNC', 'COHR', 'IRM', 'DVA', 'FRC', 'ROL', 'UAA',
            'UDR', 'GNRC', 'SBH', 'DXC', 'LKQ', 'TSN', 'JNPR', 'CHH', 'HBI', 'TDC'
        ];

        $apiKey = 'ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';

        // Batch size
        $batchSize = 100;
        $symbolChunks = array_chunk($symbols, $batchSize);

        foreach ($symbolChunks as $chunk) {
            $symbolsString = implode(',', $chunk);
            $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$symbolsString}?apikey={$apiKey}";

            // Fetch data from the API
            $response = Http::get($apiUrl);

            if ($response->failed()) {
                $this->command->error("Failed to fetch data from API for batch: {$symbolsString}");
                continue;
            }

            $stocks = $response->json();

            if (empty($stocks)) {
                $this->command->warn("No data received for batch: {$symbolsString}");
                continue;
            }

            foreach ($stocks as $stockData) {
                try {
                    DB::table('stocks')->updateOrInsert(
                        ['symbol' => $stockData['symbol']],
                        [
                            'name' => $stockData['name'],
                            'img' => "https://images.financialmodelingprep.com/symbol/{$stockData['symbol']}.png",
                            'price' => $stockData['price'],
                            'changes_percentage' => $stockData['changesPercentage'],
                            'change' => $stockData['change'],
                            'day_low' => $stockData['dayLow'],
                            'day_high' => $stockData['dayHigh'],
                            'year_low' => $stockData['yearLow'],
                            'year_high' => $stockData['yearHigh'],
                            'market_cap' => $stockData['marketCap'],
                            'price_avg_50' => $stockData['priceAvg50'],
                            'price_avg_200' => $stockData['priceAvg200'],
                            'exchange' => $stockData['exchange'],
                            'volume' => $stockData['volume'],
                            'avg_volume' => $stockData['avgVolume'],
                            'open' => $stockData['open'],
                            'previous_close' => $stockData['previousClose'],
                            'eps' => $stockData['eps'],
                            'pe' => $stockData['pe'],
                            'status' => 'active',
                            'tradeable' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                    
                    $this->command->info("Successfully inserted/updated stock: {$stockData['symbol']}");
                } catch (\Exception $e) {
                    $this->command->error("Failed to insert/update stock: {$stockData['symbol']} - " . $e->getMessage());
                    Log::error("Failed to insert/update stock: {$stockData['symbol']}", ['error' => $e->getMessage()]);
                }
            }
        }

        $this->command->info("Stock seeding completed.");
    }
}
