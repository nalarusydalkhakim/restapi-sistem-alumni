<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\TracerEntrepreneur;
use App\Models\TracerStudy;
use App\Models\TracerWork;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userQuery = User::leftjoin('faculties', 'faculties.id', '=', 'users.faculty_id')
                        ->leftjoin('departements', 'departements.id', '=', 'users.departement_id')
                        ->where('role', 'user')
                        ->when($request->search, function ($q) use ($request) {
                            return $q->where('name', 'like', '%'.$request->search.'%')
                                ->orWhere('nim', $request->search)
                                ->orWhere('nik', $request->search);
                        })->latest();

        $userQuery->select('users.*', 'faculties.faculty_name', 'departements.departement_name');

        $user = $userQuery->paginate($request->get('per_page', 10));
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
            'faculty_id' => 'required',
            'departement_id' => 'required',
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
                'messege' => 'User Created',
                'user' => $user,
                'tracer_work' => $tracer_work,
                'tracer_study' => $tracer_study,
                'tracer_entrepreneur' => $tracer_entrepreneur,
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
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
        $user = User::leftjoin('faculties', 'faculties.id', '=', 'users.faculty_id')
                        ->leftjoin('departements', 'departements.id', '=', 'users.departement_id')
                        ->findOrFail($id);
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
            'faculty_id' => 'required',
            'departement_id' => 'required',
            'entry_year' => 'required',
            'graduate_year' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'social_media' => 'required|string',
            'organization' => 'required|string',
            'achievement' => 'required|string',
            'gpa' => 'required',
            'diploma_number' => 'required|string',
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
                'messege' => 'Failed '.$e->getMessage()
            ],500);
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
                'messege' => 'Failed '.$e->getMessage()
            ],500);
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
                'messege' => 'Failed '.$e->getMessage()
            ],500);
        }
    }

    public function alumniImport()
    {
        $import_data = Excel::import(new UsersImport, request()->file('file'));
        $response = [
            'messege' => 'Import Alumni Success',
            'data' => $import_data
        ];
    
        return response($response, 201);
    }

    public function downloadTemplate()
    {
        // // Get path from storage directory
        $path = public_path("storage/document/import_alumni.xlsx");
        $filename = 'template_import_alumni.xlsx';

        // Download file with custom headers
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
        // return Storage::download('app/public/document/import_alumni.xlsx');
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
                'messege' => 'Failed '.$e->getMessage()
            ],500);
        }
    }
}
