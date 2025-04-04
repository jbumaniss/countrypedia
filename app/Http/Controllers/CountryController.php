<?php

namespace App\Http\Controllers;

use Domain\Country\Models\Country;
use Domain\Country\Services\CountryService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function __construct(private readonly CountryService $service)
    {
    }
    public function index(): Response
    {
        return Inertia::render('Country/Index', [
            'canLogin'      => Route::has('login'),
            'canRegister'   => Route::has('register'),
            'countries' => $this->service->list(),
        ]);
    }

    public function show($id): Response
    {
        $country = Country::query()->findOrFail($id);

        return Inertia::render('Country/Detail', [
            'country' => $country,
        ]);
    }
}
