<?php

use App\Http\Controllers\Spa\Store\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Test route to check if Inertia works
Route::get('/test', function () {
    return Inertia::render('Welcome');
});

// Temporary route without auth for testing
Route::get('/books-test', [BookController::class, 'index']);

// Temporarily remove auth middleware for testing
Route::resource('books', BookController::class);

require __DIR__ . '/glpi/glpi_routes.php';
