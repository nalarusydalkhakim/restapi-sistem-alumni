<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use App\Models\TracerStudy;
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

        $tracer_study = TracerStudy::findOrFail($user_id);
        $tracer_work = TracerWork::findOrFail($user_id);
        $tracer_entrepteneur = TracerEntrepreneur::findOrFail($user_id);

        
        $expired_date = null;

        if ($tracer_study->completed || $tracer_work->completed || $tracer_entrepteneur->completed) {
            $tracer_completed = 1;
            //expired_date for tracer
            if ($tracer_study->expired_date < $tracer_work->expired_date) {
                if ($tracer_work->expired_date < $tracer_entrepteneur->expired_date) {
                    $expired_date = $tracer_entrepteneur->expired_date;
                }else{
                    $expired_date = $tracer_work->expired_date;
                }
            }else{
                if ($tracer_study->expired_date < $tracer_entrepteneur->expired_date) {
                    $expired_date = $tracer_entrepteneur->expired_date;
                }else{
                    $expired_date = $tracer_study->expired_date;
                }
            }
        }else{
            $tracer_completed = 0;
        }

        $response = [
            'messege' => 'Dashboard Alumni',
            'profile_completed' => $user->completed,
            'tracer_completed' => $tracer_completed,
            'expired_date' => $expired_date
        ];

        return response($response, 200);
    }
}
