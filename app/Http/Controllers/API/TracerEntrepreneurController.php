<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TracerEntrepreneurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $tracer_entrepreneur = TracerEntrepreneur::create($request->all());

            $response = [
                'messege' => 'Tracer Entrepreneur Created',
                'tracer_entrepreneur' => $tracer_entrepreneur
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $tracer_entrepreneur = TracerEntrepreneur::where('user_id',$user_id)->firstOrFail();
        $response = [
            'messege' => 'Detail of Tracer Entrepreneur',
            'tracer_entrepreneur' => $tracer_entrepreneur
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
            'business_name' => 'required|string',
            'business_address' => 'required|string',
            'business_sector' => 'required|string',
            'business_phone' => 'required|string',
            'establish_year' => 'required|string',
            'capital_source' => 'required|string',
            'income' => 'required|numeric',
            'business_matches' => 'required',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $tracer_entrepreneur = TracerEntrepreneur::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_entrepreneur->update([
                'business_name' => $request->business_name,
                'business_address' => $request->business_address,
                'business_sector' => $request->business_sector,
                'business_phone' => $request->business_phone,
                'establish_year' => $request->establish_year,
                'capital_source' => $request->capital_source,
                'income' => $request->income,
                'business_matches' => $request->business_matches,
                'completed' => 1
            ]);

            $response = [
                'messege' => 'Tracer Entrepreneur Updated',
                'tracer_entrepreneur' => $tracer_entrepreneur
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $tracer_entrepreneur = TracerEntrepreneur::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_entrepreneur->delete();

            $response = [
                'messege' => 'Tracer Entrepreneur Deleted',
                'tracer_entrepreneur' => $tracer_entrepreneur
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }
}
