<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
use App\Models\TracerNoWork;
use App\Models\TracerStudy;
use App\Models\TracerWork;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'nik' => 'required|numeric|unique:users',
            'nim' => 'required|string|unique:users',
            'password' => 'required|min:8',
            'photo' => 'required|image:jpeg,png,jpg|max:5120',
            'identity_card' => 'required|image:jpeg,png,jpg|max:5120',
            'bachelor_certificate' => 'required|image:jpeg,png,jpg|max:5120'
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

        try {
            $user = User::create([  
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'password' => Hash::make($request->password),
                'photo' => $request->photo,
                'photo_url' => asset('storage/'.$request->photo),
                'identity_card' => $request->identity_card,
                'identity_card_url' => asset('storage/'.$request->identity_card),
                'bachelor_certificate' => $request->bachelor_certificate,
                'bachelor_certificate_url' => asset('storage/'.$request->bachelor_certificate),
            ]);
            
            // Create Tracer on Register
            $tracer_work = TracerWork::create([
                'user_id' => $user->id
            ]);

            $tracer_study = TracerStudy::create([
                'user_id' => $user->id
            ]);

            $tracer_entrepreneur = TracerEntrepreneur::create([
                'user_id' => $user->id
            ]);
    
            $response = [
                'success' => true,
                'code' => 201,
                'message' => 'Pengguna sudah terdaftar',
                'user' => $user,
                'tracer_work' => $tracer_work,
                'tracer_study' => $tracer_study,
                'tracer_entrepreneur' => $tracer_entrepreneur
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Failed '.$e->errorInfo
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string',
            'password' => 'required|min:8'
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

        $user = User::where('email', $request->username)->orWhere('nik', $request->username)->first();

        if ($user) {
            if ($user->role == 'user') {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->validated) {
                        // create token
                        $token = $user->createToken('token')->plainTextToken;
    
                        $response = [
                            'success' => true,
                            'code' => 200,
                            'message' => 'Login Berhasil',
                            'user' => $user,
                            'token' => $token
                        ];
                        return response()->json($response, 200);
    
                    }else {
                        return response()->json([
                            'success' => false,
                            'code' => 403,
                            'message' => 'Perhatian! Akun anda sedang dalam proses validasi oleh Admin. Silahkan tunggu beberapa saat lagi!'
                        ], 403);
                    }
                }else {
                    return response()->json([
                        'success' => false,
                        'code' => 422,
                        'message' => 'Password Salah'
                    ], 422);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'code' => 403,
                    'message' => 'Anda tidak seharusnya mengakses ini!'
                ], 403);
            }
        } else{
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Pengguna tidak diketahui'
            ], 404);
        }
    }

    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required|min:8'
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

        $user = User::where('email', $request->username)->first();

        if ($user) {
            if ($user->role == 'admin') {
                if (Hash::check($request->password, $user->password)) {
                     // create token
                     $token = $user->createToken('token')->plainTextToken;
    
                     $response = [
                         'success' => true,
                         'code' => 200,
                         'message' => 'Login berhasil',
                         'user' => $user,
                         'token' => $token
                     ];
                     return response()->json($response, 200);
                }else {
                    return response()->json([
                        'success' => false,
                        'code' => 422,
                        'message' => 'Password salah'
                    ], 422);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'code' => 403,
                    'message' => 'Anda tidak seharusnya mengakses ini!'
                ], 403);
            }
        } else{
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Pengguna tidak diketahui'
            ], 404);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8',
            'new_password' => 'required|min:8'
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

        $user = User::findOrFail($request->id);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Password salah'
            ], 422);
        }else{
            try {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
                $response = [   
                    'success' => true,
                    'code' => 200,
                    'message' => 'Password berhasil diubah'
                ];
        
                return response($response, 200);
                
            } catch (QueryException $e) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'message' => 'Failed '.$e->errorInfo
                ], 422);
            }
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Logout berhasil'
        ], 200);
    }
}
