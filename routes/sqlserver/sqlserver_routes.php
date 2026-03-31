<?php

use App\Http\Controllers\SqlServer\SqlServerController;
use Illuminate\Support\Facades\Route;

Route::get('/sqlserver', [SqlServerController::class, 'index'])->name('sqlserver.index');
