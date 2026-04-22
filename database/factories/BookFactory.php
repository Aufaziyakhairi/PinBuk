<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->company(),
            'publication_year' => $this->faker->year(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'available_quantity' => function (array $attributes) {
                return $attributes['quantity'];
            },
            'category' => $this->faker->randomElement(['Fiction', 'Non-Fiction', 'Science', 'History', 'Technology']),
            'location' => $this->faker->randomElement(['Rack A', 'Rack B', 'Rack C', 'Shelf 1', 'Shelf 2']),
            'status' => 'ready',
        ];
    }
}
