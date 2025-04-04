<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CountryController::class, 'index'])
    ->name('country.index');
Route::get('/country/{id}', [CountryController::class, 'show'])
    ->name('country.show');

Route::post('/supervisor/action', [SupervisorController::class, 'supervisorAction'])
    ->name('supervisor.action')
    ->middleware([
        'auth',
        'isSupervisor',
    ]);
