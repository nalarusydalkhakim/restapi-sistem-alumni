<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MigrateController extends Controller
{
    public function store(Request $request)
    {
        try {
            \Artisan::call('migrate');
            \Artisan::call('db:seed');
            return 'done';
        } catch (\Throwable $th) {
            return 'error';
        }
    }
}
