<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Country;
use App\Models\Package;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\DataProviders\CityDataProvider;
use App\DataProviders\StateDataProvider;
use App\DataProviders\CountryDataProvider;
use Faker\Factory as Faker;

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

        Country::insertOrIgnore(CountryDataProvider::data());
        State::insertOrIgnore(StateDataProvider::data());
            foreach (collect(CityDataProvider::data())->chunk(15000) as $chunkCities) {
                City::insertOrIgnore($chunkCities->toArray());
        }

        // $faker = Faker::create();

        // $stocks = [
        //     ['symbol' => 'AAPL', 'name' => 'Apple Inc.', 'img' => 'https://cdn.freebiesupply.com/images/large/2x/apple-logo-transparent.png'],
        //     ['symbol' => 'GOOGL', 'name' => 'Alphabet Inc.', 'img' => 'https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png'],
        //     ['symbol' => 'AMZN', 'name' => 'Amazon.com, Inc.', 'img' => 'https://cdn0.iconfinder.com/data/icons/most-usable-logos/120/Amazon-512.png'],
        //     ['symbol' => 'MSFT', 'name' => 'Microsoft Corporation', 'img' => 'https://ed-alliance.org/wp-content/uploads/2020/08/logo-microsoft-corporation-brand-windows-server-2016-windows-xp-png-favpng-MfQ9Eh8taScufiz3KRPuRSLjd.png'],
        //     ['symbol' => 'TSLA', 'name' => 'Tesla, Inc.', 'img' => 'https://static.vecteezy.com/system/resources/previews/020/975/670/non_2x/tesla-logo-tesla-icon-transparent-free-png.png'],
        //     ['symbol' => 'FB', 'name' => 'Facebook, Inc.', 'img' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Facebook_Logo_2023.png/768px-Facebook_Logo_2023.png'],
        //     ['symbol' => 'NFLX', 'name' => 'Netflix, Inc.', 'img' => 'https://static.vecteezy.com/system/resources/previews/017/396/804/non_2x/netflix-mobile-application-logo-free-png.png'],
        //     ['symbol' => 'NVDA', 'name' => 'NVIDIA Corporation', 'img' => 'https://seeklogo.com/images/N/nvidia-logo-2B71F1828F-seeklogo.com.png'],
        //     ['symbol' => 'BABA', 'name' => 'Alibaba Group Holding Limited', 'img' => 'https://logolook.net/wp-content/uploads/2023/10/Alibaba-Logo.png'],
        //     ['symbol' => 'V', 'name' => 'Visa Inc.', 'img' => 'https://static.vecteezy.com/system/resources/previews/020/975/576/non_2x/visa-logo-visa-icon-transparent-free-png.png'],
        //     ['symbol' => 'JNJ', 'name' => 'Johnson & Johnson', 'img' => 'https://www.pngall.com/wp-content/uploads/15/Johnson-And-Johnson-Logo-PNG-Photos.png'],
        //     ['symbol' => 'WMT', 'name' => 'Walmart Inc.', 'img' => 'https://cdn.freebiesupply.com/logos/thumbs/2x/walmart-logo.png'],
        //     ['symbol' => 'PG', 'name' => 'Procter & Gamble Co.', 'img' => 'https://upload.wikimedia.org/wikipedia/commons/f/f9/P%26G_logo.png'],
        //     ['symbol' => 'DIS', 'name' => 'The Walt Disney Company', 'img' => 'https://pngimg.com/d/walt_disney_PNG28.png'],
        //     ['symbol' => 'MA', 'name' => 'Mastercard Incorporated', 'img' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1200px-Mastercard-logo.svg.png'],
        // ];
        
        // foreach ($stocks as $stock) {
        //     Stock::create([
        //         'symbol' => $stock['symbol'], 
        //         'name' => $stock['name'], 
        //         'img' => $stock['img'],
        //         'price' => $faker->randomFloat(2, 100, 500),
        //         'changes_percentage' => $faker->randomFloat(4, -5, 5),
        //         'change' => $faker->randomFloat(2, -10, 10),
        //         'day_low' => $faker->randomFloat(2, 100, 400),
        //         'day_high' => $faker->randomFloat(2, 100, 400),
        //         'year_low' => $faker->randomFloat(2, 50, 200),
        //         'year_high' => $faker->randomFloat(2, 200, 600),
        //         'market_cap' => $faker->numberBetween(1000000000, 1000000000000),
        //         'price_avg_50' => $faker->randomFloat(4, 100, 500),
        //         'price_avg_200' => $faker->randomFloat(4, 100, 500),
        //         'exchange' => 'NASDAQ',
        //         'volume' => $faker->numberBetween(1000000, 100000000),
        //         'avg_volume' => $faker->numberBetween(1000000, 100000000),
        //         'open' => $faker->randomFloat(2, 100, 500),
        //         'previous_close' => $faker->randomFloat(2, 100, 500),
        //         'eps' => $faker->randomFloat(2, 1, 10),
        //         'pe' => $faker->randomFloat(2, 10, 50),
        //         'status' => $faker->randomElement(['active', 'inactive']),
        //         'tradeable' => 1, // Set to '1' as per your requirement
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        
    }
}
