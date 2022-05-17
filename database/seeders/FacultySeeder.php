<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
            [
                "id" => 1,
                "code" => "B",
                "faculty_name" => "Fakultas Keguruan dan Ilmu Pendidikan"
            ],
            [
                "id" => 2,
                "code" => "C",
                "faculty_name" => "Fakultas Ilmu Budaya"
            ],
            [
                "id" => 3,
                "code" => "F",
                "faculty_name" => "Fakultas Ekonomi dan Bisnis"
            ],
            [
                "id" => 4,
                "code" => "D",
                "faculty_name" => "Fakultas Ilmu Sosial dan Politik"
            ],
            [
                "id" => 5,
                "code" => "E",
                "faculty_name" => "Fakultas Hukum"
            ],
            [
                "id" => 6,
                "code" => "H",
                "faculty_name" => "Fakultas Pertanian"
            ],
            [
                "id" => 7,
                "code" => "G",
                "faculty_name" => "Fakultas Kedokteran"
            ],
            [
                "id" => 8,
                "code" => "I",
                "faculty_name" => "Fakultas Teknik"
            ],
            [
                "id" => 9,
                "code" => "M",
                "faculty_name" => "Fakultas Matematika dan Ilmu Pengetahuan Alam"
            ],
            [
                "id" => 10,
                "code" => "K",
                "faculty_name" => "Fakultas Ilmu Keolahragaan"
            ],
            [
                "id" => 11,
                "code" => "S",
                "faculty_name" => "Pascasarjana"
            ],
            [
                "id" => 12,
                "code" => "C0",
                "faculty_name" => "Fakultas Seni Rupa dan Desain"
            ],
            [
                "id" => 13,
                "code" => "V",
                "faculty_name" => "Sekolah Vokasi"
            ]
        ];
        DB::table('faculties')->insert($faculties);
    }
}
