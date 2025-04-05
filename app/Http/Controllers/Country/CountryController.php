<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use Domain\Country\Services\CountryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

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
