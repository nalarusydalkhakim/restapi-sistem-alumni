<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'password' => Hash::make($request->birth_date),
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
