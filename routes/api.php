<?php

use App\Http\Controllers\API\AlumniController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CVCOntroller;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\TracerStudyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Its For Alumni User but tami need this on public route :)
Route::get('/logout', [AuthController::class, 'logout']);
// User Profile Endpoint
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);
// Tracer Study Endpoint
Route::post('/tracer', [TracerStudyController::class, 'store']);
Route::get('/tracer/{id}', [TracerStudyController::class, 'show']);
Route::put('/tracer/{id}', [TracerStudyController::class, 'update']);
// Generate CV for Alumni
Route::get('/cv/{id}', [CVCOntroller::class, 'show']);

// For admin site
// Alumni Endpoint
Route::get('/alumni', [AlumniController::class, 'index']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);


// protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    // Route::get('/logout', [AuthController::class, 'logout']);
    // // User Profile Endpoint
    // Route::get('/profile/{id}', [ProfileController::class, 'show']);
    // Route::put('/profile/{id}', [ProfileController::class, 'update']);
    // // Tracer Study Endpoint
    // Route::post('/tracer', [TracerStudyController::class, 'store']);
    // Route::get('/tracer/{id}', [TracerStudyController::class, 'show']);
    // Route::put('/tracer/{id}', [TracerStudyController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});