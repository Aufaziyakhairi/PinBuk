<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Requests\UpdateBorrowingRequest;
use App\Models\Book;
use App\Models\Borrowing;
use App\Services\FineService;

class BorrowingController extends Controller
{
    protected FineService $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    /**
     * Display a listing of borrowing requests
     */
    public function index()
    {
        $query = Borrowing::query()->with(['user', 'book']);

        // Users see only their borrowings
        if (auth()->user()->isUser()) {
            $query->where('user_id', auth()->id());
        }

        // Filter by status if provided
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $borrowings = $query->latest()->paginate(15);

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show form to request a book
     */
    public function create()
    {
        $books = Book::where('status', 'ready')
            ->where('available_quantity', '>', 0)
            ->get();

        return view('borrowings.create', compact('books'));
    }

    /**
     * Store a borrowing request
     */
    public function store(StoreBorrowingRequest $request)
    {
        $data = $request->validated();
        $book = Book::findOrFail($data['book_id']);

        // Check if book is available
        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia');
        }

        // Create borrowing request (pending approval)
        $borrowing = Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        return redirect()->route('borrowings.show', $borrowing)
            ->with('success', 'Permohonan peminjaman buku berhasil dibuat. Menunggu persetujuan admin.');
    }

    /**
     * Display the specified borrowing
     */
    public function show(Borrowing $borrowing)
    {
        // Check authorization
        if (!auth()->user()->isAdmin() && auth()->user()->id !== $borrowing->user_id) {
            abort(403, 'Unauthorized access');
        }

        $fine = $borrowing->fine;

        return view('borrowings.show', compact('borrowing', 'fine'));
    }

    /**
     * Show form to approve/reject or return book
     */
    public function edit(Borrowing $borrowing)
    {
        // Admin can approve/reject any pending request
        if (auth()->user()->isAdmin() && $borrowing->isPending()) {
            $pendingBorrowings = Borrowing::where('status', 'pending')
                ->with(['user', 'book'])
                ->latest()
                ->get();
            return view('borrowings.approval-panel', compact('pendingBorrowings'));
        }

        // Users can return their own books if approved
        if ($borrowing->isApproved() && auth()->user()->id === $borrowing->user_id) {
            return view('borrowings.return', compact('borrowing'));
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Update borrowing status (approve/reject/return)
     */
    public function update(UpdateBorrowingRequest $request, Borrowing $borrowing)
    {
        $data = $request->validated();
        $status = $data['status'];

        // Admin approving a request
        if ($status === 'approved' && auth()->user()->isAdmin()) {
            $borrowing->update([
                'status' => 'approved',
                'borrowed_at' => now(),
                'due_date' => $data['due_date'],
            ]);

            // Decrease available quantity
            $borrowing->book->decrement('available_quantity');

            return redirect()->route('borrowings.show', $borrowing)
                ->with('success', 'Permohonan peminjaman disetujui');
        }

        // Admin rejecting a request
        if ($status === 'rejected' && auth()->user()->isAdmin()) {
            $borrowing->update(['status' => 'rejected']);

            return redirect()->route('borrowings.index')
                ->with('success', 'Permohonan peminjaman ditolak');
        }

        // User returning a book
        if ($status === 'returned' && $borrowing->isApproved()) {
            $returnDate = $data['returned_at'];
            
            $borrowing->update([
                'status' => 'returned',
                'returned_at' => $returnDate,
            ]);

            // Increase available quantity
            $borrowing->book->increment('available_quantity');

            return redirect()->route('borrowings.show', $borrowing)
                ->with('success', 'Buku berhasil dikembalikan');
        }

        return back()->with('error', 'Tidak dapat memperbarui status peminjaman');
    }

    /**
     * Approval panel for admin
     */
    public function approvalPanel()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $pendingBorrowings = Borrowing::where('status', 'pending')
            ->with(['user', 'book'])
            ->latest()
            ->get();

        return view('borrowings.approval-panel', compact('pendingBorrowings'));
    }
}

