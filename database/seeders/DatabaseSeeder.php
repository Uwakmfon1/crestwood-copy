<?php

namespace Database\Seeders;

use App\Models\Investment;
use App\Models\Package;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();
         Package::factory(10)->create();
         Investment::factory(100)->create()->each(function ($investment){
             Transaction::factory()->create(['investment_id' => $investment['id']]);
         });
         Trade::factory(100)->create()->each(function ($trade){
             Transaction::factory()->create(['trade_id' => $trade['id']]);
         });
    }
}
