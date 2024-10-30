<?php

namespace Database\Seeders;

use App\Models\Crypto;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Get the IDs of the first 300 records
        $keepIds = DB::table('cryptos')
            ->orderBy('id') // Make sure to order by the 'id' or relevant column
            ->take(300)
            ->pluck('id')
            ->toArray();

        // Step 2: Delete all records not in the $keepIds array
        DB::table('cryptos')
            ->whereNotIn('id', $keepIds)
            ->delete();

        // Optional: Output a message to confirm the operation
        $this->command->info('Excess cryptocurrencies cleared, keeping only the first 300 records.');
        
        // $faker = Faker::create();
        // $apiKey = 'ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';

        // // Step 1: Fetch stock data from API with retry logic
        // $maxRetries = 3; // Maximum number of retries
        // $attempt = 0;
        // $response = null;

        // while ($attempt < $maxRetries) {
        //     try {
        //         $response = Http::timeout(30)->get('https://financialmodelingprep.com/api/v3/stock/list?apikey=' . $apiKey);

        //         if ($response->successful()) {
        //             break; // Exit loop if request is successful
        //         }
        //     } catch (RequestException $e) {
        //         Log::error("Request failed: " . $e->getMessage());
        //     }

        //     $attempt++;
        //     sleep(1); // Wait before retrying
        // }

        // if (!$response || !$response->successful()) {
        //     Log::error("Failed to fetch stock list after {$maxRetries} attempts. Response: " . ($response ? $response->body() : 'No response'));
        //     return; // Exit if request failed
        // }

        // $stocks = $response->json();

        // // Prepare stocks data for fetching profiles
        // $stockData = [];
        // foreach ($stocks as $stock) {
        //     $stockData[] = [
        //         'symbol' => $stock['symbol'],
        //         'name' => $stock['name'],
        //         'exchange' => $stock['exchange'] ?? 'NASDAQ',
        //     ];
        // }

        // // Step 2: Fetch company profiles for all stocks
        // $symbolsString = implode(',', array_column($stockData, 'symbol'));
        // $profileResponse = Http::timeout(30)->get("https://financialmodelingprep.com/api/v3/profile/{$symbolsString}?apikey={$apiKey}");

        // // Check if profile response is successful
        // if ($profileResponse->successful()) {
        //     $profiles = $profileResponse->json();

        //     // Step 3: Prepare data for bulk upsert
        //     $upsertData = [];
        //     foreach ($profiles as $profile) {
        //         $symbol = strtoupper($profile['symbol']);
        //         $upsertData[] = [
        //             'symbol' => $symbol,
        //             'name' => $profile['companyName'] ?? null,
        //             'img' => $profile['image'] ?? null,
        //             'price' => $faker->randomFloat(2, 100, 500),
        //             'changes_percentage' => $faker->randomFloat(4, -5, 5),
        //             'change' => $faker->randomFloat(2, -10, 10),
        //             'day_low' => $faker->randomFloat(2, 100, 400),
        //             'day_high' => $faker->randomFloat(2, 100, 400),
        //             'year_low' => $faker->randomFloat(2, 50, 200),
        //             'year_high' => $faker->randomFloat(2, 200, 600),
        //             'market_cap' => $faker->numberBetween(1000000000, 1000000000000),
        //             'price_avg_50' => $faker->randomFloat(4, 100, 500),
        //             'price_avg_200' => $faker->randomFloat(4, 100, 500),
        //             'exchange' => $stockData[array_search($symbol, array_column($stockData, 'symbol'))]['exchange'],
        //             'volume' => $faker->numberBetween(1000000, 100000000),
        //             'avg_volume' => $faker->numberBetween(1000000, 100000000),
        //             'open' => $faker->randomFloat(2, 100, 500),
        //             'previous_close' => $faker->randomFloat(2, 100, 500),
        //             'eps' => $faker->randomFloat(2, 1, 10),
        //             'pe' => $faker->randomFloat(2, 10, 50),
        //             'status' => $faker->randomElement(['active', 'inactive']),
        //             'tradeable' => 1,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ];
        //     }

        //     // Step 4: Bulk upsert into the database
        //     Stock::upsert($upsertData, ['symbol'], [
        //         'name', 'img', 'price', 'changes_percentage', 'change', 
        //         'day_low', 'day_high', 'year_low', 'year_high', 
        //         'market_cap', 'price_avg_50', 'price_avg_200', 
        //         'exchange', 'volume', 'avg_volume', 'open', 
        //         'previous_close', 'eps', 'pe', 'status', 
        //         'tradeable', 'updated_at'
        //     ]);
        // } else {
        //     Log::error("Failed to fetch profiles. Response: " . $profileResponse->body());
        // }
    }



}
