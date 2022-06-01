<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::leftjoin('faculties', 'faculties.id', '=', 'users.faculty_id')
                    ->leftjoin('departements', 'departements.id', '=', 'users.departement_id')
                    ->select('name', 'email', 'nik', 'nim', 'faculties.faculty_name', 'departements.departement_name', 
                            'entry_year', 'graduate_year', 'birth_date', 'birth_place', 'gender', 'address', 'phone_number',
                            'social_media', 'gpa', 'diploma_number', 'organization', 'achievement', 'completed', 'validated')
                    ->where('role', 'user')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'nama',
            'email',
            'nik',
            'nim',
            'fakultas',
            'jurusan',
            'tahun masuk',
            'tahun lulus',
            'tanggal lahir',
            'tempat lahir',
            'jenis kelamin',
            'alamat',
            'nomor handphone',
            'sosial media',
            'ipk',
            'nomor ijazah',
            'riwayat organisasi kampus',
            'prestasi',
            'lengkap',
            'tervalidasi'
        ];
    }
}
