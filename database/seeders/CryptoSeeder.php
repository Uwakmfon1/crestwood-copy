<?php

namespace Database\Seeders;

use App\Models\Crypto;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
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
        $faker = Faker::create();
        $apiKey = 'ExYlr0LoPC6GqCmzuScjwq79Fn4Krx77';

        // Step 1: Fetch cryptocurrency data from Financial Modeling Prep API
        $response = Http::get('https://financialmodelingprep.com/api/v3/symbol/available-cryptocurrencies?apikey=' . $apiKey);

        if ($response->successful()) {
            $cryptos = $response->json();

            // Step 2: Loop through each cryptocurrency and seed the data
            foreach ($cryptos as $crypto) {
                // Extract symbol and remove the trailing "USD"
                $fullSymbol = strtoupper($crypto['symbol']);
                $symbol = str_replace('USD', '', $fullSymbol); // Remove "USD"

                $name = $crypto['name'];

                // Step 3: Fetch detailed cryptocurrency data
                $cryptoDetailsResponse = Http::get("https://financialmodelingprep.com/api/v3/profile/{$symbol}?apikey=" . $apiKey);

                // Initialize variables for the detailed data
                $price = null;
                $logoUrl = null;

                // Check if the details response is successful
                if ($cryptoDetailsResponse->successful()) {
                    $cryptoDetails = $cryptoDetailsResponse->json();
                    
                    // Check if there's at least one item in the response
                    if (isset($cryptoDetails[0])) {
                        $price = $cryptoDetails[0]['price'];
                        $logoUrl = $cryptoDetails[0]['image']; // Get the image URL from the response
                    } else {
                        Log::warning("No data found for symbol: {$symbol}");
                    }
                } else {
                    // Log the unsuccessful API request
                    Log::error("Failed to fetch details for symbol: {$symbol}. Response: " . $cryptoDetailsResponse->body());
                }

                // Insert the cryptocurrency data into the database
                Crypto::insertOrIgnore([
                    'symbol' => $symbol,
                    'name' => $name,
                    'img' => $logoUrl ?? $faker->imageUrl(), // Fallback to a random image if logo URL is not available
                    'price' => $price ?? $faker->randomFloat(2, 100, 500), // Use fetched price or a random float if not available
                    'changes_percentage' => $faker->randomFloat(4, -5, 5),
                    'change' => $faker->randomFloat(2, -10, 10),
                    'day_low' => $faker->randomFloat(2, 100, 400),
                    'day_high' => $faker->randomFloat(2, 100, 400),
                    'year_low' => $faker->randomFloat(2, 50, 200),
                    'year_high' => $faker->randomFloat(2, 200, 600),
                    'market_cap' => $faker->numberBetween(1000000000, 1000000000000),
                    'price_avg_50' => $faker->randomFloat(4, 100, 500),
                    'price_avg_200' => $faker->randomFloat(4, 100, 500),
                    'exchange' => 'Crypto Exchange',
                    'volume' => $faker->numberBetween(1000000, 100000000),
                    'avg_volume' => $faker->numberBetween(1000000, 100000000),
                    'open' => $faker->randomFloat(2, 100, 500),
                    'previous_close' => $faker->randomFloat(2, 100, 500),
                    'eps' => null,  // EPS doesn't apply to cryptocurrencies
                    'pe' => null,   // P/E ratio doesn't apply to cryptocurrencies
                    'status' => $faker->randomElement(['active', 'inactive']),
                    'tradeable' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            Log::error("Failed to fetch available cryptocurrencies. Response: " . $response->body());
        }
    }
}
