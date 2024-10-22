<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

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

            // Step 2: Loop through each stock and seed the data
            foreach ($stocks as $stock) {
                $symbol = $stock['symbol'];
                $name = $stock['name'];

                // Step 3: Fetch the company profile and logo using the symbol
                $profileResponse = Http::get("https://financialmodelingprep.com/api/v3/profile/{$symbol}?apikey={$apiKey}");

                // Check if profile response is successful
                $logoUrl = null;
                if ($profileResponse->successful() && !empty($profileResponse->json())) {
                    $profileData = $profileResponse->json()[0]; // Profile data is returned as an array
                    $logoUrl = $profileData['image'] ?? null; // Get the company logo URL
                }

                // Insert the stock data into the database
                Stock::insertOrIgnore([
                    'symbol' => $symbol,
                    'name' => $name,
                    'img' => $logoUrl,  // Add the image/logo URL from profile API
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
                    'exchange' => $stock['exchange'] ?? 'NASDAQ',
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
                ]);
            }
        }
    }
}
