<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Policies\BookPolicy;
use App\Policies\BorrowingPolicy;
use App\Policies\FinePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Book::class, BookPolicy::class);
        Gate::policy(Borrowing::class, BorrowingPolicy::class);
        Gate::policy(Fine::class, FinePolicy::class);
    }
}
