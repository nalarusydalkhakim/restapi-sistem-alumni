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

        if (auth()->user()->cannot('update', $user)) {
            return response([
                'success' => false,
                'code' => 403,
                'message' => 'Anda tidak diizinkan mengakses halaman ini',
            ], 403);
        }

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
        // Get User By id
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,'.$id,
            'nik' => 'required|numeric|unique:users,nik,'.$id,
            'nim' => 'required|string|max:255|unique:users,nim,'.$id,
            'faculty_id' => 'required|exists:faculties,id',
            'departement_id' => 'required|exists:departements,id',
            'entry_year' => 'required|date_format:Y',
            'graduate_year' => 'required|date_format:Y|after:entry_year',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'province' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'regency' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'district' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|digits_between:10,14',
            'social_media' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'achievement' => 'nullable|string|max:255',
            'gpa' => 'required|numeric|min:0|max:4',
            'diploma_number' => 'required|string|max:255',
            'photo' => 'nullable`|image:jpeg,png,jpg|max:5120',
            'identity_card' => 'nullable|image:jpeg,png,jpg|max:5120',
            'bachelor_certificate' => 'nullable|image:jpeg,png,jpg|max:5120'
        ];

        if (!$user->photo) {
            $rules['photo'] = 'required|image:jpeg,png,jpg|max:5120';
        }

        if (!$user->identity_card) {
            $rules['identity_card'] = 'required|image:jpeg,png,jpg|max:5120';
        }

        if (!$user->bachelor_certificate) {
            $rules['bachelor_certificate'] = 'required|image:jpeg,png,jpg|max:5120';
        }

        // run validation
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
        }

        if (auth()->user()->cannot('update', $user)) {
            return response([
                'success' => false,
                'code' => 403,
                'message' => 'Anda tidak diizinkan mengakses halaman ini',
            ], 403);
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
                'country' => $request->country,
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'social_media' => $request->social_media,
                'gpa' => $request->gpa, //its called ipk in indo :)
                'diploma_number' => $request->diploma_number,
                'organization' => $request->organization,
                'achievement' => $request->achievement,
                'photo' => $request->photo ?? $user->photo,
                'photo_url' => $request->photo ? asset('storage/'.$request->photo) : $user->photo_url,
                'identity_card' => $request->identity_card ?? $user->identity_card,
                'identity_card_url' => $request->identity_card ? asset('storage/'.$request->identity_card) : $user->identity_card_url,
                'bachelor_certificate' => $request->bachelor_certificate ?? $user->bachelor_certificat,
                'bachelor_certificate_url' => $request->bachelor_certificate ? asset('storage/'.$request->bachelor_certificate) : $user->bachelor_certificate_url,
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

        if (auth()->user()->cannot('update', $user)) {
            return response([
                'success' => false,
                'code' => 403,
                'message' => 'Anda tidak diizinkan mengakses halaman ini',
            ], 403);
        }
        
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