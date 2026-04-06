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

Route::get('/session/getdate', function () {
    return response()->json([
        'date' => now()->format('Y-m-d H:i:s'),
    ], 200);
});

require __DIR__.'/admin/admin_routes.php';
require __DIR__.'/glpi/glpi_routes.php';
require __DIR__.'/sqlserver/sqlserver_routes.php';
