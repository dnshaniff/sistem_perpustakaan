<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookStockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(0, 20),
        ];
    }
}
