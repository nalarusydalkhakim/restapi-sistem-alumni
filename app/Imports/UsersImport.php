<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    
    public function model(array $row)
    {
        return new User([
            'name'              => $row['nama'],
            'email'             => $row['email'],
            'nik'               => $row['nik'],
            'nim'               => $row['nim'],
            // 'password'          => Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('dmY'),
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
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'email' => 'required|unique:users|email',
            'nik' => 'required|unique:users',
            'nim' => 'required|string|unique:users',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'tempat_lahir' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'faculty_id' => 'nullable',
            'departement_id' => 'nullable',
            'alamat' => 'nullable|string',
            'nomer_hp' => 'nullable|string',
            'ipk' => 'nullable|numeric',
            'nomor_ijazah' => 'nullable|string',
            'sosmed' => 'nullable|string',
            'organisasi' => 'nullable|string',
            'prestasi' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date_format:Y-m-d',
            'tanggal_keluar' => 'nullable|date_format:Y-m-d',
        ];
    }
}
