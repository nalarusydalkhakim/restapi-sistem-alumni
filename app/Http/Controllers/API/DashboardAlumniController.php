<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use App\Models\TracerStudy;
use App\Models\TracerUpdateHistory;
use App\Models\TracerWork;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAlumniController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function showDashboard($user_id)
    {
        $user = User::findOrFail($user_id);

        $tracer =  TracerUpdateHistory::where('user_id', $user_id )->orderBy('expired_date', 'DESC')->first();

        if ($tracer) {
            $expired_date = $tracer->expired_date;
            $tracer_completed = 1;
        }else{
            $expired_date = null;
            $tracer_completed = 0;
        }

        $response = [
            'messege' => 'Dashboard Alumni',
            'profile_completed' => $user->completed,
            'profile_validated' => $user->validated,
            'tracer_completed' => $tracer_completed,
            'expired_date' => $expired_date
        ];

        return response($response, 200);
    }
}
