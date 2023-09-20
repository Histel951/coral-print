<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calculator>
 */
class CalculatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text(),
            'min_price' => $this->faker->numberBetween(100, 500),
            'active' => $this->faker->boolean,
            'calculator_type_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
