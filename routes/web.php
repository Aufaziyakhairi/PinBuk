<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book routes (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('books', BookController::class);
    });

    // Available books view (User can browse)
    Route::get('books-available', [BookController::class, 'available'])->name('books.available');

    // User management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Borrowing routes (All authenticated users)
    Route::resource('borrowings', BorrowingController::class);
    
    // Borrowing approval panel (Admin only)
    Route::get('borrowings-approval/panel', [BorrowingController::class, 'approvalPanel'])
        ->name('borrowings.approval-panel')
        ->middleware('admin');

    // Fine routes (All authenticated users)
    Route::resource('fines', FineController::class)->only(['index', 'show', 'destroy']);
    Route::get('fines/create', [FineController::class, 'create'])->name('fines.create')->middleware('admin');
    Route::post('fines', [FineController::class, 'store'])->name('fines.store')->middleware('admin');
    Route::post('fines/{fine}/mark-as-paid', [FineController::class, 'markAsPaid'])->name('fines.mark-paid');

    // Monthly reports for admin
    Route::get('fines/reports/monthly', [FineController::class, 'monthlyReport'])
        ->name('fines.monthly-report')
        ->middleware('admin');
});

require __DIR__.'/auth.php';
