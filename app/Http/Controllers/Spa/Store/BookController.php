<?php

namespace App\Http\Controllers\Spa\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreSpaBookRequest;
use App\Http\Requests\Store\UpdateSpaBookRequest;
use App\Models\Store\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search filters
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('author') && $request->author) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->has('pages') && $request->pages) {
            $query->where('pages', '=', $request->pages);
        }

        if ($request->has('price') && $request->price) {
            $query->where('price', '=', $request->price);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', '=', $request->status);
        }

        $books = $query->paginate(15);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'filters' => $request->only(['name', 'author', 'pages', 'price', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Books/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpaBookRequest $request)
    {
        $book = Book::create($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpaBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
