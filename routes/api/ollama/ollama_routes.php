<?php

use App\Http\Controllers\Api\Ollama\OllamaController;
use Illuminate\Support\Facades\Route;

Route::get('/ollama', [OllamaController::class, 'index'])->name('ollama.index');
