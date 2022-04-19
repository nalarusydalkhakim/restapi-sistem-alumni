<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use App\Models\TracerStudy;
use App\Models\TracerWork;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_count = User::count();
        $user_completed_count = User::where('completed', 1)->count();
        $user_uncompleted_count = $user_count - $user_completed_count;
        $tracer_study_count = TracerStudy::where('completed', 1)->count();
        $tracer_work_count = TracerWork::where('completed', 1)->count();
        $tracer_entrepreneur_count = TracerEntrepreneur::where('completed', 1)->count();
        $tracer_completed_count = User::join('tracer_update_histories', 'tracer_update_histories.user_id', '=', 'users.id')
                                        ->groupBy('users.id')
                                        ->get()
                                        ->count();
        $tracer_uncompleted_count = $user_count - $tracer_completed_count;

        $response = [
            'messege' => 'Dashboard Admin',
            'user_count' => $user_count,
            'user_completed_count' => $user_completed_count,
            'user_uncompleted_count' => $user_uncompleted_count,
            'tracer_study_count' => $tracer_study_count,
            'tracer_work_count' => $tracer_work_count,
            "tracer_entrepreneur_count" => $tracer_entrepreneur_count,
            'tracer_completed_count' => $tracer_completed_count,
            'tracer_uncompleted_count' => $tracer_uncompleted_count 
        ];

        return response($response, 200);
    }
}
