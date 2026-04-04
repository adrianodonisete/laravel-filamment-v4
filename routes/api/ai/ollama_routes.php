<?php

use App\Http\Controllers\Api\Ollama\LlmController;
use App\Http\Controllers\Api\Ollama\OllamaController;
use Illuminate\Support\Facades\Route;

Route::get('/ollama/llm', [LlmController::class, 'index'])
    ->name('ollama.llm');

Route::post('/ollama', [OllamaController::class, 'index'])
    ->name('ollama.index');
Route::post('/ollama/expand-product-name', [OllamaController::class, 'expandProductName'])
    ->name('ollama.expand-product-name');
