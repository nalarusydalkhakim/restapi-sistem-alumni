<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::leftjoin('faculties', 'faculties.id', '=', 'users.faculty_id')
                        ->leftjoin('departements', 'departements.id', '=', 'users.departement_id')
                        ->select('users.*', 'faculties.faculty_name', 'departements.departement_name')
                        ->findOrFail($id);
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'Detail of User Profile',
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
            'nik' => 'required|numeric',
            'nim' => 'required|string',
            'faculty_id' => 'required',
            'departement_id' => 'required',
            'entry_year' => 'required|date_format:Y',
            'graduate_year' => 'required|date_format:Y|after:entry_year',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|digits_between:10,14',
            'social_media' => 'required|string',
            'organization' => 'required|string',
            'achievement' => 'required|string',
            'gpa' => 'required|numeric',
            'diploma_number' => 'required|string',
            'photo' => 'nullable|image:jpeg,png,jpg|max:5120',
            'identity_card' => 'nullable|image:jpeg,png,jpg|max:5120',
            'bachelor_certificate' => 'nullable|image:jpeg,png,jpg|max:5120'
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

        if ($request->file('photo')) {
            $photo_path = $request->file('photo')->store('uploads/foto');
            $request->photo = $photo_path;
        }

        if ($request->file('identity_card')) {
            $identity_card_path = $request->file('identity_card')->store('uploads/ktp');
            $request->identity_card = $identity_card_path;
        }

        if ($request->file('bachelor_certificate')) {
            $bachelor_certificate_path = $request->file('bachelor_certificate')->store('uploads/ijazah');
            $request->bachelor_certificate = $bachelor_certificate_path;
        }
        
        $user = User::findOrFail($id);

        try {
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'faculty_id' => $request->faculty_id,
                'departement_id' => $request->departement_id,
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
                'organization' => $request->organization,
                'achievement' => $request->achievement,
                'photo' => $request->photo,
                'photo_url' => asset('storage/'.$request->photo),
                'identity_card' => $request->identity_card,
                'identity_card_url' => asset('storage/'.$request->identity_card),
                'bachelor_certificate' => $request->bachelor_certificate,
                'bachelor_certificate_url' => asset('storage/'.$request->bachelor_certificate),
                'first' => 0,
                'completed' => 1,
            ]);

            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Profile Pengguna Berhasil Diperbarui',
                'user' => $user
            ];
    
            return response($response, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed :'.$th->getMessage()
            ], 500);
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
        $user = User::findOrFail($id);
        try {
            $user->delete();
            $response = [
                'success' => true,
                'code' => 200,
                'messege' => 'Pengguna berhasil dihapus'
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
