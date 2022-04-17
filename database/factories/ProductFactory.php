<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'max_ltv' => $this->faker->numberBetween(50, 90),
            'fee' => $this->faker->randomFloat(2, 0.01, 3),
            'interest_rate' => $this->faker->randomFloat(2, 0.01, 3),
            'featured' => $this->faker->boolean,
        ];
    }
}
