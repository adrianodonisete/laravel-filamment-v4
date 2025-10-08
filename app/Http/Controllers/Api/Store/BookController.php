<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreBookRequest;
use App\Http\Requests\Store\UpdateBookRequest;
use App\Http\Resources\Api\Store\BookResource;
use App\Models\Store\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
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

        return response()->json([
            'data' => BookResource::collection($books),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ],
            'links' => [
                'first' => $books->url(1),
                'last' => $books->url($books->lastPage()),
                'prev' => $books->previousPageUrl(),
                'next' => $books->nextPageUrl(),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Book created successfully',
            'data' => $request->all(),
        ], 200);

        // try {
        //     // $validated = $request->validated();

        //     $book = Book::create($request->all());

        //     return response()->json([
        //         'message' => 'Book created successfully',
        //         'data' => new BookResource($book),
        //     ], 201);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'Error creating book',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json([
            'data' => new BookResource($book),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        try {
            $book->update($request->validated());

            return response()->json([
                'message' => 'Book updated successfully',
                'data' => new BookResource($book),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): JsonResponse
    {
        try {
            $book->delete();

            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
