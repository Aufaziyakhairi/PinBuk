<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'borrowing_id',
    'user_id',
    'description',
    'status',
])]
class Fine extends Model
{
    use HasFactory;

    /**
     * Get the borrowing associated with this fine
     */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    /**
     * Get the user who owes the fine
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if fine is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}

