<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use App\Models\TracerUpdateHistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(),[
            'university_name' => 'required|string',
            'university_address' => 'required|string',
            'study_location' => 'required|string',
            'departement' => 'required|string',
            'entry_year' => 'required',
            'graduate_year' => 'required',
            'study_matches' => 'required',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $tracer_study = TracerStudy::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_study->update([
                'university_name' => $request->university_name,
                'university_address' => $request->university_address,
                'study_location' => $request->study_location,
                'departement' => $request->departement,
                'entry_year' => $request->entry_year,
                'graduate_year' => $request->graduate_year,
                'study_matches' => $request->study_matches,
                'completed' => 1,
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $tracer_update_history = TracerUpdateHistory::create([
                'user_id' => $user_id,
                'update_date' => Carbon::now()->format('Y-m-d'),
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $response = [
                'messege' => 'Tracer Study Updated',
                'tracer_study' => $tracer_study,
                'tracer_update_history' => $tracer_update_history
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
