<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nim' => $request->nim,
                'password' => Hash::make($request->password)
            ]);
       
            $token = $user->createToken('token')->plainTextToken;
    
            $response = [
                'messege' => 'User Registed',
                'user' => $user,
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

    public function change_password(Request $request)
    {
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
