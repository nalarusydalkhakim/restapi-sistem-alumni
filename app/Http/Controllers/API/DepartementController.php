<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departement = Departement::get();
        $response = [
            'messege' => 'List of Departement',
            'Departement' => $departement
        ];

        return response($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'faculty_id' => 'required|string',
            'Departement_name' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        try {
            $departement = Departement::create([
                'faculty_id' => $request->faculty_id,
                'Departement_name' => $request->Departement_name
            ]);
    
            $response = [
                'messege' => 'Departement Created',
                'Departement' => $departement
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
    public function show($id)
    {
        $departement = Departement::findOrFail($id);
        $response = [
            'messege' => 'Detail of Department',
            'Departement' => $departement
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'faculty_id' => 'required|string',
            'Departement_name' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $departement = Departement::findOrFail($id);

        try {
            $departement->update([
                'faculty_id' => $request->faculty_id,
                'Departement_name' => $request->Departement_name
            ]);
    
            $response = [
                'messege' => 'Department Updated',
                'Departement' => $departement
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
    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        try {
            $departement->delete();
            $response = [
                'messege' => 'Departement Deleted'
            ];
    
            return response($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }
}