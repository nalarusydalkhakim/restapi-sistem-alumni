<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerUpdateHistory;
use App\Models\TracerWork;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TracerWorkController extends Controller
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
            $tracer_work = TracerWork::create($request->all());

            $response = [
                'success' => true,
                'code' => 200,
                'messege' => 'Tracer Bekerja Berhasil Dibuat',
                'tracer_work' => $tracer_work
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
        $tracer_work = TracerWork::where('user_id',$user_id)->firstOrFail();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'Detail of Tracer Work',
            'tracer_work' => $tracer_work
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
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_sector' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'contract_status' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'job_matches' => 'required|boolean',
            'start_working' => 'required|date',
            'get_job_from' => 'required|string|max:255',
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
        
        $tracer_work = TracerWork::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_work->update([
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_sector' => $request->company_sector,
                'position' => $request->position,
                'contract_status' => $request->contract_status,
                'salary' => $request->salary,
                'job_matches' => $request->job_matches,
                'start_working' => $request->start_working,
                'get_job_from' => $request->get_job_from,
                'completed' => 1,
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $tracer_update_history = TracerUpdateHistory::create([
                'user_id' => $user_id,
                'completed' => 1,
                'description' => 'Bekerja',
                'update_date' => Carbon::now()->format('Y-m-d'),
                'expired_date' => Carbon::now()->addMonths(6)->format('Y-m-d')
            ]);

            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Tracer Bekerja Berhasil Diperbarui',
                'tracer_work' => $tracer_work,
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
        $tracer_work = TracerWork::where('user_id',$user_id)->firstOrFail();

        try {
            $tracer_work->delete();

            $response = [
                'success' => true,
                'code' => 200,
                'messege' => 'Tracer Bekerja Berhasil Dihapus',
                'tracer_work' => $tracer_work
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
