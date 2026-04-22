<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFineRequest;
use App\Models\Fine;
use App\Services\FineService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    protected FineService $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fines = Fine::query()
            ->with(['user', 'borrowing.book'])
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(auth()->user()->isUser(), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(15);

        return view('fines.index', compact('fines'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Fine $fine)
    {
        // Allow admin to view any, users to view own
        if (auth()->user()->isUser() && auth()->user()->id !== $fine->user_id) {
            abort(403, 'Unauthorized access');
        }

        return view('fines.show', compact('fine'));
    }

    /**
     * Mark fine as paid
     */
    public function markAsPaid(Fine $fine)
    {
        // Only admin can mark as paid
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $this->fineService->markAsPaid($fine);

        return redirect()->route('fines.show', $fine)
            ->with('success', 'Denda berhasil dibayar');
    }

    /**
     * Display monthly reports (Admin only)
     */
    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $fines = Fine::query()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with('user', 'borrowing.book')
            ->get();

        $totalFines = $fines->count();
        $totalPaid = $fines->where('status', 'paid')->count();
        $totalUnpaid = $fines->where('status', 'unpaid')->count();

        return view('fines.monthly-report', compact(
            'fines',
            'totalFines',
            'totalPaid',
            'totalUnpaid',
            'month',
            'year'
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fine $fine)
    {
        $this->authorize('delete', $fine);

        $fine->delete();

        return redirect()->route('fines.index')
            ->with('success', 'Denda berhasil dihapus');
    }

    /**
     * Show form to create a new fine manually (Admin only)
     */
    public function create()
    {
        // Only admin can create fines manually
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Get overdue borrowings that don't have fines yet
        $overdueBorrowings = \App\Models\Borrowing::query()
            ->where('status', 'returned')
            ->whereNotNull('returned_at')
            ->whereNotNull('due_date')
            ->where('due_date', '<', \Illuminate\Support\Facades\DB::raw('returned_at'))
            ->doesntHave('fine')
            ->with(['user', 'book'])
            ->get();

        return view('fines.create', compact('overdueBorrowings'));
    }

    /**
     * Store a newly created fine (Admin only)
     */
    public function store(StoreFineRequest $request)
    {
        $validated = $request->validated();

        $borrowing = \App\Models\Borrowing::findOrFail($validated['borrowing_id']);

        // Check if borrowing is returned and overdue
        if ($borrowing->status !== 'returned' || !$borrowing->isOverdue()) {
            return back()->with('error', 'Peminjaman ini tidak memenuhi syarat untuk diberikan denda');
        }

        // Check if fine already exists
        if ($borrowing->fine) {
            return back()->with('error', 'Denda untuk peminjaman ini sudah ada');
        }

        // Create fine
        $fine = Fine::create([
            'borrowing_id' => $borrowing->id,
            'user_id' => $borrowing->user_id,
            'description' => $validated['description'],
            'status' => 'unpaid',
        ]);

        return redirect()->route('fines.show', $fine)
            ->with('success', 'Denda berhasil dibuat');
    }
}
