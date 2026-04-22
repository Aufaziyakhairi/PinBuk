<?php

namespace App\Policies;

use App\Models\Fine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Admin and users can view fines
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fine $fine): bool
    {
        // Admin can view any, users can only view own
        return $user->isAdmin() || $user->id === $fine->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Fines are auto-created by system
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fine $fine): bool
    {
        return $user->isAdmin(); // Only admin can update fines
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fine $fine): bool
    {
        return $user->isAdmin(); // Only admin can delete
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fine $fine): bool
    {
        return $user->isAdmin(); // Only admin can restore
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fine $fine): bool
    {
        return $user->isAdmin(); // Only admin can force delete
    }
}
