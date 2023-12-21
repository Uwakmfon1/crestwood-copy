<?php

namespace Database\Factories;

use App\Models\Investment;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()['id'],
            // 'user_id' => User::all()->random()['id'],
            'package_id' => Package::all()->random()['id'],
            'slots' => $this->faker->randomDigit,
            'amount' => $this->faker->randomNumber(5),
            'total_return' => $this->faker->randomNumber(5),
            'investment_date' => now(),
            'return_date' => now()->addMonths($this->faker->randomNumber(1)),
            'status' => $this->faker->randomElement(['active', 'pending', 'cancelled', 'settled'])
        ];
    }
}
