<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerUpdateHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TracerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUpdateHistory($user_id)
    {
        $tracer_update_history = TracerUpdateHistory::where('user_id',$user_id)->get();
        $response = [
            'messege' => 'List of Tracer Update History',
            'tracer_update_history' => $tracer_update_history
        ];
        return response($response, 200);
    }
}
