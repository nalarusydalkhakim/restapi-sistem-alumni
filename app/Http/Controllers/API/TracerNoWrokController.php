<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerUpdateHistory;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TracerNoWrokController extends Controller
{
   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function noWork($user_id)
    {
        try {
            $tracer_update_history = TracerUpdateHistory::create([
                'user_id' => $user_id,
                'completed' => 1,
                'description' => 'Tidak Bekerja',
                'update_date' => Carbon::now()->format('Y-m-d'),
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Tracer Study Berhasil Diupdate',
                'tracer_update_history' => $tracer_update_history
            ];
    
            return response($response, 201);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->getMessage()
            ],500);
        }
    }
}
