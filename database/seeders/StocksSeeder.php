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
        $apiUrl = 'https://financialmodelingprep.com/api/v3/symbol/NASDAQ?apikey=ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';
        
        // Fetch data from the API
        $this->command->info("Fetching data from API...");
        $response = Http::get($apiUrl);

        if ($response->failed()) {
            $this->command->error("Failed to fetch data from API.");
            return;
        }

        $stocks = $response->json();

        if (empty($stocks)) {
            $this->command->warn("No data received from API.");
            return;
        }

        // Loop through each stock and insert into the database
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

        $this->command->info("Stock seeding completed.");
    }
}
