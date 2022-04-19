<?php

// use App\Http\Controllers\API\Admin\AlumniController;
// use App\Http\Controllers\API\Alumni\AuthController;
// use App\Http\Controllers\API\Alumni\TracerStudyController;
// use App\Http\Controllers\API\Alumni\ProfileController;
// use App\Http\Controllers\API\Alumni\CVCOntroller;

use App\Http\Controllers\API\AlumniController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CVCOntroller;
use App\Http\Controllers\API\DashboardAlumniController;
use App\Http\Controllers\API\DepartementController;
use App\Http\Controllers\API\FacultyController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\TracerController;
use App\Http\Controllers\API\TracerEntrepreneurController;
use App\Http\Controllers\API\TracerStudyController;
use App\Http\Controllers\API\TracerWorkController;
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
// Dashboard Alumni
Route::get('/dashboard/{id}', [DashboardAlumniController::class, 'showDashboard']);
// User Profile Endpoint
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::post('/profile/{id}', [ProfileController::class, 'update']);
// All Tracer Endpoint
Route::get('tracer/{id}', [TracerController::class, 'getUpdateHistory']);
// Tracer Study Endpoint
// Route::post('/tracer_s', [TracerStudyController::class, 'store']);
Route::get('/tracer_s/{id}', [TracerStudyController::class, 'show']);
Route::put('/tracer_s/{id}', [TracerStudyController::class, 'update']);
// Tracer Work Endpoint
// Route::post('/tracer_w', [TracerWorkController::class, 'store']);
Route::get('/tracer_w/{id}', [TracerWorkController::class, 'show']);
Route::post('/tracer_w/{id}', [TracerWorkController::class, 'update']);
// Tracer Entrepreneur Endpoint
// Route::post('/tracer_e', [TracerEntrepreneurController::class, 'store']);
Route::get('/tracer_e/{id}', [TracerEntrepreneurController::class, 'show']);
Route::put('/tracer_e/{id}', [TracerEntrepreneurController::class, 'update']);
// Generate CV for Alumni
Route::get('/cv/{id}', [CVCOntroller::class, 'show']);

// For admin site
// Alumni Endpoint
Route::get('/alumni', [AlumniController::class, 'index']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
// validate alumni by admin endpoint
Route::put('/validate/{id}', [AlumniController::class, 'setValidate']);
Route::put('/unvalidate/{id}', [AlumniController::class, 'unValidate']);
// Faculty Endpoint
Route::get('/faculty', [FacultyController::class, 'index']);
Route::post('/faculty', [FacultyController::class, 'store']);
Route::get('/faculty/{id}', [FacultyController::class, 'show']);
Route::put('/faculty/{id}', [FacultyController::class, 'update']);
Route::delete('/faculty/{id}', [FacultyController::class, 'destroy']);
// Departement Endpoint
Route::get('/departement', [DepartementController::class, 'index']);
Route::post('/departement', [DepartementController::class, 'store']);
Route::get('/departement/{id}', [DepartementController::class, 'show']);
Route::put('/departement/{id}', [DepartementController::class, 'update']);
Route::delete('/departement/{id}', [DepartementController::class, 'destroy']);




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