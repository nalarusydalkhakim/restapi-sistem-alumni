<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'          => $row['nama'],
            'email'         => $row['email'],
            'nik'           => $row['nik'],
            'nim'           => $row['nim'],
            'password'      => Hash::make(Carbon::createFromFormat('Y-m-d', $row['tanggal_lahir'])->format('dmY')), //ex. from 1999-05-23 to 23051999
            'faculty'       => $row['fakultas'],
            'departement'   => $row['jurusan_prodi'],
            'entry_year'    => $row['tahun_masuk'],
            'graduate_year' => $row['tahun_lulus'],
            'birth_date'    => $row['tanggal_lahir'],
            'birth_place'   => $row['tempat_lahir'],
            'gender'        => $row['jenis_kelamin'],
            'address'       => $row['alamat'],
            'phone_number'  => $row['nomer_hp'],
            'social_media'  => $row['sosmed'],
            'gpa'           => $row['ipk'],
            'diploma_number' => $row['nomor_ijazah'],
            'organization'  => $row['organisasi'],
            'achievement'   => $row['prestasi'],
         ]);
    }
}
