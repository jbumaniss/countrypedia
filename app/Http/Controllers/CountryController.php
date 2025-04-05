<?php

namespace App\Http\Controllers;

use Domain\Country\Models\Country;
use Domain\Country\Services\CountryService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private readonly CountryService $service)
    {
    }
    public function index(Request $request): Response
    {
        $search = $request->input('search');

        return Inertia::render('Country/Index', [
            'canLogin'      => Route::has('login'),
            'canRegister'   => Route::has('register'),
            'countries' => $this->service->list($search),
        ]);
    }

    public function show($id): Response
    {
        return Inertia::render('Country/Detail', [
            'country' => $this->service->show($id),
        ]);
    }
}
