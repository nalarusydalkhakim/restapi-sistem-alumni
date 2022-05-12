<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerEntrepreneur;
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
    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'nik' => 'required|string|unique:users',
            'nim' => 'required|string|unique:users',
            'password' => 'required|min:8'
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
                'password' => Hash::make($request->password)
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

            // Create Token for Authorization
            $token = $user->createToken('token')->plainTextToken;
    
            $response = [
                'messege' => 'User Registed',
                'user' => $user,
                'tracer_work' => $tracer_work,
                'tracer_study' => $tracer_study,
                'tracer_entrepreneur' => $tracer_entrepreneur,
                'token' => $token
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->username)->orWhere('nik', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'UNAUTHORIZED'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ];

        return response()->json([$response, 200]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ]);

        // run validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::findOrFail($request->id);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'UNAUTHORIZED'
            ], 401);
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            $response = [
                'messege' => 'Password Changed'
            ];
    
            return response($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'messege' => 'Failed '.$e->errorInfo
            ]);
        }
    }

    public function Logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'messege' => 'Logout Success'
        ]);
    }
}
