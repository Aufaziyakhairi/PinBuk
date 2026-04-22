<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title',
    'author',
    'isbn',
    'description',
    'publisher',
    'publication_year',
    'quantity',
    'available_quantity',
    'category',
    'location',
    'status',
])]
class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get all borrowing records for this book
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Check if book is available
     */
    public function isAvailable(): bool
    {
        return $this->available_quantity > 0 && $this->status === 'ready';
    }
}

