<?php

namespace Database\Factories;

use App\Models\Fine;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fine>
 */
class FineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'borrowing_id' => Borrowing::factory(),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
        ];
    }
}

