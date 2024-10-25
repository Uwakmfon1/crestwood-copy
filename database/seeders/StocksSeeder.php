<?php

namespace Database\Seeders;

use App\Models\Stock;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
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
        $faker = Faker::create();
        $apiKey = 'ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';

        // Step 1: Fetch stock data from API
        $response = Http::get('https://financialmodelingprep.com/api/v3/stock/list?apikey=' . $apiKey);

        if ($response->successful()) {
            $stocks = $response->json();

            // Prepare stocks data for fetching profiles (only US stocks)
            $stockData = [];
            foreach ($stocks as $stock) {
                if (in_array($stock['exchange'], ['NASDAQ', 'NYSE'])) {
                    $stockData[] = [
                        'symbol' => $stock['symbol'],
                        'name' => $stock['name'] ?? null,
                        'exchange' => $stock['exchange'] ?? 'NASDAQ',
                    ];
                }
            }

            if (!empty($stockData)) {
                // Step 2: Split symbols into batches to avoid URI limit
                $symbolBatches = array_chunk(array_column($stockData, 'symbol'), 50); // Limit batch to 50 symbols

                $upsertData = [];
                foreach ($symbolBatches as $batch) {
                    $symbolsString = implode(',', $batch);
                    $profileResponse = Http::get("https://financialmodelingprep.com/api/v3/profile/{$symbolsString}?apikey={$apiKey}");

                    if ($profileResponse->successful()) {
                        $profiles = $profileResponse->json();

                        foreach ($profiles as $profile) {
                            $symbol = strtoupper($profile['symbol']);
                            $upsertData[] = [
                                'symbol' => $symbol,
                                'name' => $profile['companyName'] ?? null,
                                'img' => $profile['image'] ?? null,
                                'price' => $faker->randomFloat(2, 100, 500),
                                'changes_percentage' => $faker->randomFloat(4, -5, 5),
                                'change' => $faker->randomFloat(2, -10, 10),
                                'day_low' => $faker->randomFloat(2, 100, 400),
                                'day_high' => $faker->randomFloat(2, 100, 400),
                                'year_low' => $faker->randomFloat(2, 50, 200),
                                'year_high' => $faker->randomFloat(2, 200, 600),
                                'market_cap' => $faker->numberBetween(1000000000, 1000000000000),
                                'price_avg_50' => $faker->randomFloat(4, 100, 500),
                                'price_avg_200' => $faker->randomFloat(4, 100, 500),
                                'exchange' => $stockData[array_search($symbol, array_column($stockData, 'symbol'))]['exchange'],
                                'volume' => $faker->numberBetween(1000000, 100000000),
                                'avg_volume' => $faker->numberBetween(1000000, 100000000),
                                'open' => $faker->randomFloat(2, 100, 500),
                                'previous_close' => $faker->randomFloat(2, 100, 500),
                                'eps' => $faker->randomFloat(2, 1, 10),
                                'pe' => $faker->randomFloat(2, 10, 50),
                                'status' => $faker->randomElement(['active', 'inactive']),
                                'tradeable' => 1,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    } else {
                        Log::error("Failed to fetch profiles for batch. Response: " . $profileResponse->body());
                    }
                }

                // Step 3: Bulk upsert all batches into the database
                if (!empty($upsertData)) {
                    Stock::upsert($upsertData, ['symbol'], [
                        'name', 'img', 'price', 'changes_percentage', 'change', 
                        'day_low', 'day_high', 'year_low', 'year_high', 
                        'market_cap', 'price_avg_50', 'price_avg_200', 
                        'exchange', 'volume', 'avg_volume', 'open', 
                        'previous_close', 'eps', 'pe', 'status', 
                        'tradeable', 'updated_at'
                    ]);
                }
            } else {
                Log::info("No US stocks found in the stock list.");
            }
        } else {
            Log::error("Failed to fetch stock list. Response: " . $response->body());
        }
    }





}
