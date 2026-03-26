<?php

use App\Http\Controllers\Api\OpenAI\OpenAIController;
use Illuminate\Support\Facades\Route;

Route::post('/openai/index', [OpenAIController::class, 'index'])
    ->name('openai.index');

Route::post('/openai/fake', [OpenAIController::class, 'fake'])
    ->name('openai.fake');
