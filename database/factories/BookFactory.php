<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "isbn" => fake()->unique()->numberBetween(1000000000000, 9999999999999),
            "name" => fake()->words(3,true),
            "stock" => fake()->numberBetween(1,30),
            "book_price" => fake()->randomFloat(2,1,30)
        ];
    }
}
