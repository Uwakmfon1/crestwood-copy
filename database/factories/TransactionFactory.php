<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 19,
            // 'user_id' => User::all()->random()['id'],
            'type' => $this->faker->randomElement(['deposit', 'withdrawal', 'others']),
            'amount' => $this->faker->randomNumber(5),
            'description' => "Test",
            'status' => $this->faker->randomElement(['approved', 'pending', 'declined'])
        ];
    }
}
