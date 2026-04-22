<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::query()
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->when(request('category'), function ($query) {
                $query->where('category', request('category'));
            })
            ->paginate(15);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $data['available_quantity'] = $data['quantity'];

        Book::create($data);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $borrowings = $book->borrowings()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('books.show', compact('book', 'borrowings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        // If quantity is changed, adjust available_quantity
        if (isset($data['quantity']) && $data['quantity'] !== $book->quantity) {
            $difference = $data['quantity'] - $book->quantity;
            $data['available_quantity'] = max(0, $book->available_quantity + $difference);
        }

        $book->update($data);

        return redirect()->route('books.show', $book)
            ->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }

    /**
     * Display available books for users to borrow
     */
    public function available()
    {
        $books = Book::query()
            ->where('status', 'ready')
            ->where('available_quantity', '>', 0)
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->when(request('category'), function ($query) {
                $query->where('category', request('category'));
            })
            ->paginate(12);

        // Get unique categories for filter
        $categories = Book::query()
            ->where('status', 'ready')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('books.available', compact('books', 'categories'));
    }
}

