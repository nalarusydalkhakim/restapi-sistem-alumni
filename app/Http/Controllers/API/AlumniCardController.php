<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TracerUpdateHistory;
use App\Models\User;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniCardController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateAlumniCard($user_id)
    {
        $user = User::leftjoin('faculties', 'faculties.id', '=', 'users.faculty_id')
                        ->leftjoin('departements', 'departements.id', '=', 'users.departement_id')
                        ->findOrFail($user_id);
        $tracer = TracerUpdateHistory::where('user_id', $user_id )->orderBy('expired_date', 'DESC')->first();
        
        if ($tracer) {
            if ($user->completed) {
                if ($user->validated) {
                    $data = [
                        'title' => 'Kartu Alumni UNS',
                        'date' => date('m/d/Y'),    
                        'name' => $user->name,
                        'nik' => $user->nik,
                        'no_member' => $user->nim,
                        'birth' => $user->birth_place.', '.date("d M Y", strtotime($user->birth_date)),
                        'fac_dep' => $user->faculty_name.' / '.$user->departement_name,
                        'graduate_year' => date("d M Y", strtotime($user->graduate_year)),
                        'expired_date' => date("d M Y", strtotime($tracer->expired_date)),
                        'photo' => $user->photo,
                    ];
            
                    // $customPaper = array(0,0,257, 322);
                      
                    $pdf = PDF::loadView('card', $data);
                    // ->setPaper('A6', 'potrait')
                    return $pdf->stream('Kartu_Alumni.pdf');
                }else {
                    return response()->json([
                        'success' => false,
                        'code' => 403,
                        'message' => 'Pengguna belum divalidasi admin'
                    ], 403);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'code' => 403,
                    'message' => 'Profile pengguna tidak lengkap'
                ], 403);
            }
        }else{
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'Pengguna belum mengisi Tracer Study'
            ], 403);
        }
    }
}
