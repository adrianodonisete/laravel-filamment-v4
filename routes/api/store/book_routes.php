<?php

use App\Http\Controllers\Api\Store\BookController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('books', BookController::class);
});
