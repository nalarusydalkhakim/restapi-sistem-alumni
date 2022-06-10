<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use App\Models\TracerUpdateHistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
                'success' => true,
                'code' => 201,
                'messege' => 'Tracer Wiraswasta Berhasil Dibuat',
                'tracer_entrepreneur' => $tracer_entrepreneur
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
            'success' => true,
            'code' => 200,
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
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'business_sector' => 'required|string|max:255',
            'business_phone' => 'required|digits_between:10,14',
            'establish_year' => 'required|date_format:Y',
            'capital_source' => 'required|string|max:255',
            'income' => 'required|numeric',
            'business_matches' => 'required',//
        ]);

        // run validation
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
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
                'completed' => 1,
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $tracer_update_history = TracerUpdateHistory::create([
                'user_id' => $user_id,
                'completed' => 1,
                'description' => 'Wirausaha',
                'update_date' => Carbon::now()->format('Y-m-d'),
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Tracer Wiraswasta Berhasil Diperbarui',
                'tracer_entrepreneur' => $tracer_entrepreneur,
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
                'success' => true,
                'code' => 200,
                'messege' => 'Tracer Wiraswasta Berhasil Dihapus',
                'tracer_entrepreneur' => $tracer_entrepreneur
            ];
    
            return response($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->getMessage()
            ],500);
        }
    }
}
