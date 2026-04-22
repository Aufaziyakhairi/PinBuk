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
            'activeBorrowings',
            'pastBorrowings',
            'unpaidFines'
        ));
    }

    /**
     * Analytics and reporting dashboard
     */
    public function analytics()
    {
        // Basic counts
        $totalBooks = Book::count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $totalBorrowings = Borrowing::count();
        
        // Detailed statistics
        $activeBorrowings = Borrowing::where('status', 'approved')->count();
        $onTimeBorrowings = Borrowing::where('status', 'approved')
            ->where('due_date', '>=', now())
            ->count();
        $overdueBorrowings = Borrowing::where('status', 'approved')
            ->where('due_date', '<', now())
            ->count();
        
        // Book statistics
        $availableBooks = Book::sum('available_quantity');
        $borrowedBooks = Book::sum(\Illuminate\Support\Facades\DB::raw('quantity - available_quantity'));
        $bookAvailability = $totalBooks > 0 ? round(($availableBooks / Book::sum('quantity')) * 100, 1) : 0;
        
        // Return rate
        $returnedBorrowings = Borrowing::where('status', 'returned')->count();
        $returnRate = $totalBorrowings > 0 ? round(($returnedBorrowings / $totalBorrowings) * 100, 1) : 0;
        
        // User activity
        $activeUsers = Borrowing::distinct('user_id')->count();
        $pendingViolations = Fine::where('status', 'unpaid')->count();
        $avgBorrowingsPerUser = $totalUsers > 0 ? round($totalBorrowings / $totalUsers, 1) : 0;
        
        // Top books
        $topBooks = Book::withCount(['borrowings' => function ($query) {
            $query->where('status', '!=', 'rejected');
        }])
            ->orderBy('borrowings_count', 'desc')
            ->limit(10)
            ->get();
        
        // Recent activities
        $recentActivities = Borrowing::with('user', 'book')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('dashboard.analytics', compact(
            'totalBooks',
            'totalUsers',
            'totalBorrowings',
            'activeBorrowings',
            'onTimeBorrowings',
            'overdueBorrowings',
            'availableBooks',
            'borrowedBooks',
            'bookAvailability',
            'returnRate',
            'activeUsers',
            'pendingViolations',
            'avgBorrowingsPerUser',
            'topBooks',
            'recentActivities'
        ));
    }
}
