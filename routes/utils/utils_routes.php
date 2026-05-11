<?php

use App\Http\Controllers\Utils\CsvToJsonController;
use Illuminate\Support\Facades\Route;

Route::get('/utils/csv-to-json', [CsvToJsonController::class, 'index'])->name('utils.csv-to-json.index');
Route::post('/utils/csv-to-json', [CsvToJsonController::class, 'store'])->name('utils.csv-to-json.store');
