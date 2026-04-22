<?php

namespace App\Services;

use App\Models\Borrowing;
use App\Models\Fine;

class FineService
{
    /**
     * Create fine for overdue borrowing with description
     */
    public function createFine(Borrowing $borrowing, string $description): ?Fine
    {
        // Only create if approved status, returned, and overdue
        if ($borrowing->status !== 'approved' || $borrowing->returned_at === null || !$borrowing->isOverdue()) {
            return null;
        }

        // Check if fine already exists
        if ($borrowing->fine) {
            return $borrowing->fine;
        }

        $fine = Fine::create([
            'borrowing_id' => $borrowing->id,
            'user_id' => $borrowing->user_id,
            'description' => $description,
            'status' => 'unpaid',
        ]);

        return $fine;
    }

    /**
     * Mark fine as paid
     */
    public function markAsPaid(Fine $fine): Fine
    {
        $fine->update([
            'status' => 'paid',
        ]);

        return $fine;
    }
}
