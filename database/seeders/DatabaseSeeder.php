<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Crypto;
use App\Models\Country;
use App\Models\Package;
use App\Models\Investment;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\DataProviders\CityDataProvider;
use App\DataProviders\StateDataProvider;
use App\DataProviders\StockDataProvider;
use App\DataProviders\CryptoDataProvider;
use App\DataProviders\CountryDataProvider;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  User::factory(10)->create();
        //  Package::factory(10)->create();
        //  Investment::factory(100)->create()->each(function ($investment){
        //      Transaction::factory()->create(['investment_id' => $investment['id']]);
        //  });
        //  Trade::factory(100)->create()->each(function ($trade){
        //      Transaction::factory()->create(['trade_id' => $trade['id']]);
        //  });

        // Country::insertOrIgnore(CountryDataProvider::data());
        // State::insertOrIgnore(StateDataProvider::data());
        //     foreach (collect(CityDataProvider::data())->chunk(15000) as $chunkCities) {
        //         City::insertOrIgnore($chunkCities->toArray());
        // }

        $faker = Faker::create();
        
        $cryptos = CryptoDataProvider::data();

        // $cryptos = StockDataProvider::data();
        
        foreach ($cryptos as $stock) {
            Crypto::insertOrIgnore([
            // Stock::insertOrIgnore([
                'symbol' => $stock['symbol'],
                'name' => $stock['name'],
                'img' => $stock['img'],
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
                'exchange' => 'NASDAQ',
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
