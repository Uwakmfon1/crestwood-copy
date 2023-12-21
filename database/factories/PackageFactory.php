<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'roi' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomNumber(4),
            'duration' => $this->faker->randomNumber(1),
            'description' => $this->faker->sentence,
            'image' => $this->faker->image(null, 200, 200),
            'investment' => $this->faker->randomElement(['enabled', 'disabled']),
        ];
    }
}
