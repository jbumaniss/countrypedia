<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CountryController::class, 'index'])
    ->name('country.index');
Route::get('/country/{id}', [CountryController::class, 'show'])
    ->name('country.show');
