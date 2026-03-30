<?php

use App\Http\Controllers\Api\Bedrock\BedrockController;
use Illuminate\Support\Facades\Route;

Route::post('/bedrock/expand-product-name', [BedrockController::class, 'expandProductName'])
    ->name('bedrock.expand-product-name');

Route::post('/bedrock/expand-product-names-batch', [BedrockController::class, 'expandProductNamesBatch'])
    ->name('bedrock.expand-product-names-batch');

Route::post('/bedrock/test-profile', [BedrockController::class, 'testProfile'])
    ->name('bedrock.test-profile');
