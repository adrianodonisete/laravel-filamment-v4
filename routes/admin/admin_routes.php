<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')
    ->prefix('admin')
    ->group(function (): void {
        Route::get('/login', [AuthController::class, 'login'])
            ->name('login');

        Route::post('/auth', [AuthController::class, 'auth'])
            ->name('auth');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/products', [AdminController::class, 'index'])
            ->name('products.index');

        Route::get('/categories', [AdminController::class, 'index'])
            ->name('categories.index');

        Route::get('/customers', [AdminController::class, 'index'])
            ->name('customers.index');

        Route::get('/users', [AdminController::class, 'index'])
            ->name('users.index');
    });
