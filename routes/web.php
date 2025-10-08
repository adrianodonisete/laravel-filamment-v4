<?php

use App\Http\Controllers\Spa\Store\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class);
});

require __DIR__ . '/glpi/glpi_routes.php';
