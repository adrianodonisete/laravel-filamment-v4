<?php

use App\Http\Controllers\Api\Ollama\OllamaController;
use Illuminate\Support\Facades\Route;

Route::post('/ollama', [OllamaController::class, 'index'])
    ->name('ollama.index');
Route::post('/ollama/expand-product-name', [OllamaController::class, 'expandProductName'])
    ->name('ollama.expand-product-name');
