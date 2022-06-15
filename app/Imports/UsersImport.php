<?php

namespace App\Imports;

use App\Models\TracerEntrepreneur;
use App\Models\TracerStudy;
use App\Models\TracerWork;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class UsersImport implements ToCollection, SkipsEmptyRows, WithHeadingRow, WithValidation
{
    use Importable;

   public function collection(Collection $rows)
   {
        foreach ($rows as $row) 
        {
            $user = User::create([
                'name'              => $row['nama'],
                'email'             => $row['email'],
                'nik'               => $row['nik'],
                'nim'               => $row['nim'],
                // 'password'          => $row['tanggal_lahir'],
                // 'password'          => Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('d-m-Y'),
                'password'          => Hash::make(Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('dmY')), //ex. from 1999-05-23 to 23051999
                'faculty_id'        => $row['faculty_id'],
                'departement_id'    => $row['departement_id'],
                'entry_year'        => $row['tahun_masuk'],
                'graduate_year'     => $row['tahun_lulus'],
                'birth_date'        => $row['tanggal_lahir'],
                'birth_place'       => $row['tempat_lahir'],
                'gender'            => $row['jenis_kelamin'],
                'address'           => $row['alamat'],
                'phone_number'      => $row['nomer_hp'],
                'social_media'      => $row['sosmed'],
                'gpa'               => $row['ipk'],
                'diploma_number'    => $row['nomor_ijazah'],
                'organization'      => $row['organisasi'],
                'achievement'       => $row['prestasi'],
                'validated'         => 1,
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
        }
   }
    
    // public function model(array $row)
    // {

    //     $user = new User([
    //         'name'              => $row['nama'],
    //         'email'             => $row['email'],
    //         'nik'               => $row['nik'],
    //         'nim'               => $row['nim'],
    //         // 'password'          => $row['tanggal_lahir'],
    //         // 'password'          => Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('d-m-Y'),
    //         'password'          => Hash::make(Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('dmY')), //ex. from 1999-05-23 to 23051999
    //         'faculty_id'        => $row['faculty_id'],
    //         'departement_id'    => $row['departement_id'],
    //         'entry_year'        => $row['tahun_masuk'],
    //         'graduate_year'     => $row['tahun_lulus'],
    //         'birth_date'        => $row['tanggal_lahir'],
    //         'birth_place'       => $row['tempat_lahir'],
    //         'gender'            => $row['jenis_kelamin'],
    //         'address'           => $row['alamat'],
    //         'phone_number'      => $row['nomer_hp'],
    //         'social_media'      => $row['sosmed'],
    //         'gpa'               => $row['ipk'],
    //         'diploma_number'    => $row['nomor_ijazah'],
    //         'organization'      => $row['organisasi'],
    //         'achievement'       => $row['prestasi'],
    //     ]);

    //     $tracer_study = TracerStudy::create([
    //         'user_id' => $user->id
    //     ]);

    //     return $user;
    // }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|unique:users|email',
            'nik' => 'required|unique:users',
            'nim' => 'required|string|max:255|unique:users',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'tempat_lahir' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'faculty_id' => 'nullable|exists:faculties,id',
            'departement_id' => 'nullable|exists:departements,id',
            'alamat' => 'nullable|string',
            'nomer_hp' => 'nullable||digits_between:10,14',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'nomor_ijazah' => 'nullable|string|max:255',
            'sosmed' => 'nullable|string|max:255',
            'organisasi' => 'nullable|string|max:255',
            'prestasi' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date_format:Y',
            'tanggal_keluar' => 'nullable|date_format:Y|after:tanggal_masuk',
        ];
    }

    public function isFormatDateValid($date, $format){
        $dt = Carbon::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
      }
}
