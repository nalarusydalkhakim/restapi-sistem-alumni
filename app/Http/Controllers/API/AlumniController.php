<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        $response = [
            'messege' => 'List of Alumni',
            'user' => $user
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'nik' => 'required|string|unique:users',
            'nim' => 'required|string|unique:users',
            'birth_date' => 'required',
            'birth_place' => 'required|string',
            'gender' => 'required|string',
            'faculty' => 'required|string',
            'departement' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'password' => Hash::make(Carbon::createFromFormat('Y-m-d', $request->birth_date)->format('dmY')), //ex. from 1999-05-23 to 23051999
                'faculty' => $request->faculty,
                'departement' => $request->departement,
                'entry_year' => $request->entry_year,
                'graduate_year' => $request->graduate_year,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'social_media' => $request->social_media,
                'gpa' => $request->gpa, //its called ipk in indo :)
                'diploma_number' => $request->diploma_number,
                'organization' => $request->prganization,
                'achievement' => $request->achievement,
            ]);
    
            $response = [
                'messege' => 'User Created',
                'user' => $user
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
        $user = User::findOrFail($id);
        $response = [
            'messege' => 'Detail of Alumni',
            'user' => $user
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
            'name' => 'required|string',
            'email' => 'required|string|email',
            'nik' => 'required|string',
            'nim' => 'required|string',
            'birth_date' => 'required',
            'birth_place' => 'required|string',
            'gender' => 'required|string',
            'faculty' => 'required|string',
            'departement' => 'required|string',
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::findOrFail($id);
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'faculty' => $request->faculty,
                'departement' => $request->departement,
                'entry_year' => $request->entry_year,
                'graduate_year' => $request->graduate_year,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'social_media' => $request->social_media,
                'gpa' => $request->gpa, //its called ipk in indo :)
                'diploma_number' => $request->diploma_number,
                'organization' => $request->prganization,
                'achievement' => $request->achievement,
            ]);
            $response = [
                'messege' => 'Alumni Updated',
                'user' => $user
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }


    // Validation Alumni by Admin
    public function setValidate($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->update([
                'validated' => 1
            ]);
            $response = [
                'messege' => 'Alumni Validated'
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    public function unValidate($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->update([
                'validated' => 0
            ]);
            $response = [
                'messege' => 'Alumni Unvalidated'
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    public function alumniImport(Request $request)
    {
        $import_data = Excel::import(new UsersImport, request()->file('file'));
        $response = [
            'messege' => 'Import Alumni Success',
            'data' => $import_data
        ];
    
        return response($response, 201);
    }


    /**
     * Remove the specified resource from storage.
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->delete();
            $response = [
                'messege' => 'Alumni Deleted'
            ];
    
            return response($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }
}
