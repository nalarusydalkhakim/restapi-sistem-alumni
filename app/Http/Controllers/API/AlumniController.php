<?php

namespace App\Http\Controllers\API;

use App\Exports\AlumniExport;
use App\Exports\TracerExport;
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
            'success' => true,
            'code' => 200,
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users|email',
            'nik' => 'required|numeric|unique:users',
            'nim' => 'required|string|max:255|unique:users',
            'faculty_id' => 'nullable|exists:faculties,id',
            'departement_id' => 'nullable|exists:faculties,id',
            'entry_year' => 'nullable|date_format:Y',
            'graduate_year' => 'nullable|date_format:Y|after:entry_year',
            'birth_date' => 'required|date',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'province' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'regency' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'district' => 'exclude_unless:country,Indonesia|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|digits_between:10,14',
            'social_media' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'achievement' => 'nullable|string|max:255',
            'gpa' => 'required|numeric|min:0|max:4',
            'diploma_number' => 'nullable|string|max:255',
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
                'validated' => 1,
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
                'messege' => 'Alumni berhasil terdaftar',
                'user' => $user,
                'tracer_work' => $tracer_work,
                'tracer_study' => $tracer_study,
                'tracer_entrepreneur' => $tracer_entrepreneur,
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
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
                        ->select('users.*', 'faculties.faculty_name', 'departements.departement_name')
                        ->findOrFail($id);
        $response = [
            'success' => true,
            'code' => 200,
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,'.$id,
            'nik' => 'required|numeric|unique:users,nik,'.$id,
            'nim' => 'required|string|max:255|unique:users,nim,'.$id,
            'faculty_id' => 'required|exists:faculties,id',
            'departement_id' => 'required|exists:faculties,id',
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
            'photo' => 'nullable|image:jpeg,png,jpg|max:5120',
            'identity_card' => 'nullable|image:jpeg,png,jpg|max:5120',
            'bachelor_certificate' => 'nullable|image:jpeg,png,jpg|max:5120',
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
            ]);
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Data Alumni Diperbarui',
                'user' => $user
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
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
                'success' => true,
                'code' => 201,
                'messege' => 'Alumni Berhasil Tervalidasi'
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
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
                'success' => true,
                'code' => 201,
                'messege' => 'Alumni Tidak Tervalidasi'
            ];
    
            return response($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messege' => 'Failed '.$e->getMessage()
            ],500);
        }
    }

    public function alumniImport(Request $request)
    {
        // $import = Excel::import(new UsersImport, $request->file('file'));
        $import = new UsersImport;
        try { 
            $import->import($request->file('file'));
            $response = [
                'success' => true,
                'code' => 201,
                'messege' => 'Import Data Alumni Berhasil',
                'data' => $import
            ];
            
            return response($response, 201);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             
             foreach ($failures as $failure) {
                 $failure->row(); // row that went wrong
                 $failure->attribute(); // either heading key (if using heading row concern) or column index
                 $failure->errors(); // Actual error messages from Laravel validator
                 $failure->values(); // The values of the row that has failed.
             }

             $response = [
                'success' => false,
                'code' => 422,
                'messege' => 'Eror Pada Baris '.$failure->row().' Pada Kolom '.$failure->attribute().' : '.implode(" dan ",$failure->errors()),
                'errors' => $e->failures()
            ];
            
            return response($response, 422);
        }
    }

    public function alumniExport()
    {
        return Excel::download(new AlumniExport, 'alumni.xlsx');
    }

    public function tracerExport()
    {
        return Excel::download(new TracerExport, 'tracer_alumni.xlsx');
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
        $tracer_study = TracerStudy::where('user_id',$id)->firstOrFail();
        $tracer_work = TracerWork::where('user_id',$id)->firstOrFail();
        $tracer_entrepreneur = TracerEntrepreneur::where('user_id',$id)->firstOrFail();
        try {
            $user->delete();
            $tracer_study->delete();
            $tracer_work->delete();
            $tracer_entrepreneur->delete();
            $response = [
                'success' => true,
                'code' => 200,
                'messege' => 'Alumni Berhasil Dihapus'
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