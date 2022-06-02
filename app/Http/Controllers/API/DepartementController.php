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
        $departement = Departement::leftjoin('faculties', 'faculties.id', '=', 'departements.faculty_id')
                        ->select('departements.*', 'faculties.faculty_name')
                        ->get();
        $response = [
            'success' => true,
            'code' => 200,
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
            'success' => true,
            'code' => 200,
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
            $response = [
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
        }
        
        try {
            $departement = Departement::create([
                'faculty_id' => $request->faculty_id,
                'departement_name' => $request->departement_name
            ]);
    
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Jurusan berhasil ditambahkan',
                'departement' => $departement
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->errorInfo
            ],500);
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
            'success' => true,
            'code' => 200,
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
            $response = [
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
        }
        
        $departement = Departement::findOrFail($id);

        try {
            $departement->update([
                'faculty_id' => $request->faculty_id,
                'departement_name' => $request->departement_name
            ]);
    
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Jurusan berhasil diperbarui',
                'departement' => $departement
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->errorInfo
            ],500);
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
                'success' => true,
                'code' => 200,
                'messege' => 'Jurusan berhasil dihapus'
            ];
    
            return response($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }
}
