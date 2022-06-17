<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MigrateController extends Controller
{
    public function store(Request $request)
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
            \Artisan::call('config:clear');
            //\Artisan::call('migrate');
            //\Artisan::call('db:seed');
            //\Artisan::call('storage:link');
            \Artisan::call('optimize');
            return 'done';
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
