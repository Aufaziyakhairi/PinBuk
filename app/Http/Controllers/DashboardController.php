<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard page
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    /**
     * Admin dashboard with statistics
     */
    protected function adminDashboard()
    {
        $totalBooks = Book::count();
        $totalBorrowings = Borrowing::count();
        $activeBorrowings = Borrowing::where('status', 'approved')->count();
        $pendingRequests = Borrowing::where('status', 'pending')->count();
        $totalFines = Fine::count();
        $unpaidFines = Fine::where('status', 'unpaid')->count();

        $overdueBorrowings = Borrowing::where('status', 'approved')
            ->where('due_date', '<', now())
            ->with('user', 'book')
            ->get();

        $recentBorrowings = Borrowing::with('user', 'book')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalBooks',
            'totalBorrowings',
            'activeBorrowings',
            'pendingRequests',
            'totalFines',
            'unpaidFines',
            'overdueBorrowings',
            'recentBorrowings'
        ));
    }

    /**
     * User dashboard
     */
    protected function userDashboard()
    {
        $user = auth()->user();

        // Pending requests
        $pendingRequests = $user->borrowings()
            ->where('status', 'pending')
            ->with('book')
            ->get();

        // Active (approved) borrowings
        $activeBorrowings = $user->borrowings()
            ->where('status', 'approved')
            ->with('book')
            ->get();

        // Past borrowings
        $pastBorrowings = $user->borrowings()
            ->where('status', 'returned')
            ->with('book')
            ->latest()
            ->limit(10)
            ->get();

        // Unpaid fines
        $unpaidFines = $user->fines()
            ->where('status', 'unpaid')
            ->get();

        return view('dashboard.user', compact(
            'pendingRequests',
            'activeBorrowings',
            'pastBorrowings',
            'unpaidFines'
        ));
    }
}

