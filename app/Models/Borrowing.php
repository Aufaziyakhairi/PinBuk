<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'book_id',
    'borrowed_at',
    'due_date',
    'returned_at',
    'status',
])]
class Borrowing extends Model
{
    use HasFactory;

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the user who borrowed the book
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowed book
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the fine for this borrowing
     */
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    /**
     * Check if borrowing is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if borrowing is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if borrowing is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if borrowing is returned
     */
    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    /**
     * Check if borrowing is overdue
     */
    public function isOverdue(): bool
    {
        // Check if still approved and past due date
        if ($this->status === 'approved' && $this->returned_at === null && $this->due_date && now()->isAfter($this->due_date)) {
            return true;
        }
        
        // Check if returned late
        if ($this->status === 'returned' && $this->returned_at && $this->due_date && $this->returned_at->isAfter($this->due_date)) {
            return true;
        }
        
        return false;
    }

    /**
     * Get days overdue
     */
    public function getDaysLate(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $returned = $this->returned_at ?? now();
        return (int) $this->due_date->diffInDays($returned);
    }
}

