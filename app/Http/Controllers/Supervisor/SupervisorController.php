<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    public function supervisorAction(): JsonResponse
    {
        Artisan::command('import:countries', function () {
            Log::info('Importing countries...');
        });

        return response()->json([
            'message' => 'Supervisor action executed successfully.',
        ]);
    }
}
