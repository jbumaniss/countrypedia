<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Domain\Language\Services\LanguageService;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function __construct(private readonly LanguageService $service)
    {
    }

    public function show($id): Response
    {
        return Inertia::render('Language/Detail', [
            'language' => $this->service->show($id),
        ]);
    }
}
