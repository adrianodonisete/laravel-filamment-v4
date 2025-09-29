<?php

use App\Http\Controllers\Glpi\ControleGlpiController;
use Illuminate\Support\Facades\Route;

Route::get('/glpi', function () {
    return redirect()->route('glpi.controle-glpi.index');
});

Route::name('glpi.')
    ->prefix('glpi')
    ->group(function () {
        Route::resource('controle-glpi', ControleGlpiController::class)->except(['show', 'destroy']);
    });
