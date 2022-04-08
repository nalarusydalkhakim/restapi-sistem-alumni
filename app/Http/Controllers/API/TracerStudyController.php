<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $tracer_study = TracerStudy::create($request->all());

            $response = [
                'messege' => 'Tracer Study Created',
                'tracer_study' => $tracer_study
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $tracer_study = TracerStudy::where('user_id',$user_id)->firstOrFail();
        $response = [
            'messege' => 'Detail of Tracer Study',
            'tracer_study' => $tracer_study
        ];

        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $tracer_study = TracerStudy::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_study->update($request->all());

            $response = [
                'messege' => 'Tracer Study Updated',
                'tracer_study' => $tracer_study
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $tracer_study = TracerStudy::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_study->delete();

            $response = [
                'messege' => 'Tracer Study Deleted',
                'tracer_study' => $tracer_study
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }
}
