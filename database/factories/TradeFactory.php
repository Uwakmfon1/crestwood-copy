<?php

namespace Database\Factories;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id' => User::all()->random()['id'],
            'user_id' => 19,
            'grams' => $this->faker->randomDigit,
            'product' => $this->faker->randomElement(['gold', 'silver']),
            'type' => $this->faker->randomElement(['buy', 'sell']),
            'amount' => $this->faker->randomNumber(5),
            'status' => $this->faker->randomElement(['success', 'pending', 'failed'])
        ];
    }
}
