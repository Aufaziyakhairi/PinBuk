<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random status for testing
        $status = $this->faker->randomElement(['pending', 'approved', 'rejected', 'returned']);
        
        $borrowedAt = null;
        $dueDate = null;
        $returnedAt = null;
        
        if ($status === 'approved' || $status === 'returned') {
            $borrowedAt = $this->faker->dateTimeBetween('-30 days', 'now');
            $dueDate = $this->faker->dateTimeBetween($borrowedAt, '+30 days');
        }
        
        if ($status === 'returned') {
            $returnedAt = $this->faker->dateTimeBetween($dueDate, 'now');
        }
        
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'borrowed_at' => $borrowedAt,
            'due_date' => $dueDate,
            'returned_at' => $returnedAt,
            'status' => $status,
        ];
    }
}

