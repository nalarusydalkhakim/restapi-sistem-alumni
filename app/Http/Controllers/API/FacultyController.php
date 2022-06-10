<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Faculty;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculty = Faculty::get();
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'List of Faculties',
            'faculty' => $faculty
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
            'code' => 'required|string|max:10|unique:faculties',
            'faculty_name' => 'required|string|max:255',
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
            $faculty = Faculty::create([
                'code' => $request->code,
                'faculty_name' => $request->faculty_name
            ]);
    
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Fakultas berhasil ditambahkan',
                'faculty' => $faculty
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
    public function show($id)
    {
        $faculty = Faculty::findOrFail($id);
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'Detail of Faculty',
            'faculty' => $faculty
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
            'code' => 'required|string|max:10',
            'faculty_name' => 'required|string|max:255',
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
        
        $faculty = Faculty::findOrFail($id);

        try {
            $faculty->update([
                'code' => $request->code,
                'faculty_name' => $request->faculty_name
            ]);
    
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Fakultas berhasil diperbaharui',
                'faculty' => $faculty
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
    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);

        try {
            $faculty->delete();
            // Delete department that have relation on faculty
            Departement::where('faculty_id', $id)->delete();
            $response = [
                'success' => true,
                'code' => 200,
                'messege' => 'Fakultas berhasil dihapus'
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
