<?php

use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\Supervisor\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CountryController::class, 'index'])
    ->name('countries.index');
Route::get('/countries/{id}', [CountryController::class, 'show'])
    ->name('countries.show');

Route::get('/languages/{id}', [LanguageController::class, 'show'])
    ->name('languages.show');

Route::post('/supervisor/action', [SupervisorController::class, 'supervisorAction'])
    ->name('supervisor.action')
    ->middleware([
        'auth',
        'isSupervisor',
    ]);
