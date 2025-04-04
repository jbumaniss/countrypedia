<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    public function supervisorAction(): void
    {
        Artisan::command('import:countries', function () {
            Log::info('Importing countries...');
        });
    }
}
