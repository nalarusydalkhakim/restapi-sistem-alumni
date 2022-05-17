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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listDepartements($faculty_id)
    {
        $departement = Departement::where('faculty_id', $faculty_id)->get();
        $response = [
            'messege' => 'List of Departement By Faculty Id',
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
            'departement_name' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        try {
            $departement = Departement::create([
                'faculty_id' => $request->faculty_id,
                'departement_name' => $request->departement_name
            ]);
    
            $response = [
                'messege' => 'Departement Created',
                'departement' => $departement
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
            'departement' => $departement
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
            'departement_name' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $departement = Departement::findOrFail($id);

        try {
            $departement->update([
                'faculty_id' => $request->faculty_id,
                'departement_name' => $request->departement_name
            ]);
    
            $response = [
                'messege' => 'Department Updated',
                'departement' => $departement
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
