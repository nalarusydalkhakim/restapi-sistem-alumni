<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departements = [
            [
                "id" => 3,
                "faculty_id" => 1,
                "departement_name" => "S-3 Pendidikan Bahasa Indonesia"
            ],
            [
                "id" => 4,
                "faculty_id" => 1,
                "departement_name" => "S-3 Ilmu Pendidikan"
            ],
            [
                "id" => 5,
                "faculty_id" => 1,
                "departement_name" => "S-3 Pendidikan Ilmu Pengetahuan Alam"
            ],
            [
                "id" => 6,
                "faculty_id" => 1,
                "departement_name" => "S-3 Pendidikan Sejarah"
            ],
            [
                "id" => 7,
                "faculty_id" => 1,
                "departement_name" => "S-3 Pendidikan Ekonomi"
            ],
            [
                "id" => 8,
                "faculty_id" => 2,
                "departement_name" => "S-3 Linguistik"
            ],
            [
                "id" => 10,
                "faculty_id" => 3,
                "departement_name" => "S-3 Ilmu Ekonomi"
            ],
            [
                "id" => 11,
                "faculty_id" => 4,
                "departement_name" => "S-3 Ilmu Komunikasi"
            ],
            [
                "id" => 12,
                "faculty_id" => 5,
                "departement_name" => "S-3 Ilmu Hukum"
            ],
            [
                "id" => 13,
                "faculty_id" => 6,
                "departement_name" => "S-3 Ilmu Pertanian"
            ],
            [
                "id" => 14,
                "faculty_id" => 7,
                "departement_name" => "S-3 Ilmu Kedokteran"
            ],
            [
                "id" => 15,
                "faculty_id" => 8,
                "departement_name" => "S-3 Ilmu Teknik Sipil"
            ],
            [
                "id" => 16,
                "faculty_id" => 8,
                "departement_name" => "S-3 Ilmu Teknik Mesin"
            ],
            [
                "id" => 17,
                "faculty_id" => 9,
                "departement_name" => "S-3 Biologi"
            ],
            [
                "id" => 18,
                "faculty_id" => 9,
                "departement_name" => "S-3 Fisika"
            ],
            [
                "id" => 19,
                "faculty_id" => 10,
                "departement_name" => "S-3 Ilmu Keolahragaan"
            ],
            [
                "id" => 20,
                "faculty_id" => 11,
                "departement_name" => "S-3 Ilmu Lingkungan"
            ],
            [
                "id" => 21,
                "faculty_id" => 11,
                "departement_name" => "S-3 Ilmu Penyuluhan Pembangunan"
            ],
            [
                "id" => 22,
                "faculty_id" => 11,
                "departement_name" => "S-3 Kajian Budaya"
            ],
            [
                "id" => 23,
                "faculty_id" => 11,
                "departement_name" => "S-3 Ilmu Kesehatan Masyarakat"
            ],
            [
                "id" => 24,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Ekonomi"
            ],
            [
                "id" => 25,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Sejarah"
            ],
            [
                "id" => 26,
                "faculty_id" => 1,
                "departement_name" => "S-2 Teknologi Pendidikan"
            ],
            [
                "id" => 27,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Bahasa Indonesia"
            ],
            [
                "id" => 28,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Geografi"
            ],
            [
                "id" => 29,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Sains"
            ],
            [
                "id" => 30,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Matematika"
            ],
            [
                "id" => 31,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Bahasa Inggris"
            ],
            [
                "id" => 32,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Seni"
            ],
            [
                "id" => 33,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Guru Sekolah Dasar"
            ],
            [
                "id" => 34,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Luar Biasa"
            ],
            [
                "id" => 35,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Bahasa dan Sastra Daerah"
            ],
            [
                "id" => 36,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Fisika"
            ],
            [
                "id" => 37,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Pancasila dan Kewarganegaraan"
            ],
            [
                "id" => 38,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Kimia"
            ],
            [
                "id" => 39,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Biologi"
            ],
            [
                "id" => 40,
                "faculty_id" => 1,
                "departement_name" => "S-2 Pendidikan Guru Vokasi"
            ],
            [
                "id" => 41,
                "faculty_id" => 2,
                "departement_name" => "S-2 Ilmu Linguistik"
            ],
            [
                "id" => 42,
                "faculty_id" => 3,
                "departement_name" => "S-2 Akuntansi"
            ],
            [
                "id" => 43,
                "faculty_id" => 3,
                "departement_name" => "S-2 Manajemen"
            ],
            [
                "id" => 44,
                "faculty_id" => 3,
                "departement_name" => "S-2 Ekonomi dan Studi Pembangunan"
            ],
            [
                "id" => 45,
                "faculty_id" => 4,
                "departement_name" => "S-2 Ilmu Administrasi Publik"
            ],
            [
                "id" => 46,
                "faculty_id" => 4,
                "departement_name" => "S-2 Ilmu Komunikasi"
            ],
            [
                "id" => 47,
                "faculty_id" => 4,
                "departement_name" => "S-2 Sosiologi"
            ],
            [
                "id" => 48,
                "faculty_id" => 5,
                "departement_name" => "S-2 Ilmu Hukum"
            ],
            [
                "id" => 49,
                "faculty_id" => 5,
                "departement_name" => "S-2 Kenotariatan"
            ],
            [
                "id" => 50,
                "faculty_id" => 6,
                "departement_name" => "S-2 Agribisnis"
            ],
            [
                "id" => 51,
                "faculty_id" => 6,
                "departement_name" => "S-2 Agronomi"
            ],
            [
                "id" => 52,
                "faculty_id" => 6,
                "departement_name" => "S-2 Ilmu Tanah"
            ],
            [
                "id" => 53,
                "faculty_id" => 6,
                "departement_name" => "S-2 Peternakan"
            ],
            [
                "id" => 54,
                "faculty_id" => 7,
                "departement_name" => "S-2 Ilmu Kedokteran Keluarga"
            ],
            [
                "id" => 55,
                "faculty_id" => 8,
                "departement_name" => "S-2 Teknik Mesin"
            ],
            [
                "id" => 56,
                "faculty_id" => 8,
                "departement_name" => "S-2 Teknik Sipil"
            ],
            [
                "id" => 57,
                "faculty_id" => 8,
                "departement_name" => "S-2 Teknik Industri"
            ],
            [
                "id" => 58,
                "faculty_id" => 8,
                "departement_name" => "S-2 Teknik Kimia"
            ],
            [
                "id" => 59,
                "faculty_id" => 8,
                "departement_name" => "S-2 Arsitektur"
            ],
            [
                "id" => 60,
                "faculty_id" => 9,
                "departement_name" => "S-2 Ilmu Fisika"
            ],
            [
                "id" => 61,
                "faculty_id" => 9,
                "departement_name" => "S-2 Biosains"
            ],
            [
                "id" => 62,
                "faculty_id" => 9,
                "departement_name" => "S-2 Kimia"
            ],
            [
                "id" => 63,
                "faculty_id" => 12,
                "departement_name" => "S-2 Seni Rupa"
            ],
            [
                "id" => 65,
                "faculty_id" => 10,
                "departement_name" => "S-2 Ilmu Keolahragaan"
            ],
            [
                "id" => 66,
                "faculty_id" => 11,
                "departement_name" => "S-2 Kajian Budaya"
            ],
            [
                "id" => 67,
                "faculty_id" => 11,
                "departement_name" => "S-2 Ilmu Gizi"
            ],
            [
                "id" => 68,
                "faculty_id" => 11,
                "departement_name" => "S-2 Penyuluhan Pembangunan"
            ],
            [
                "id" => 69,
                "faculty_id" => 11,
                "departement_name" => "S-2 Ilmu Kesehatan Masyarakat"
            ],
            [
                "id" => 70,
                "faculty_id" => 11,
                "departement_name" => "S-2 Ilmu Lingkungan"
            ],
            [
                "id" => 71,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Sejarah"
            ],
            [
                "id" => 72,
                "faculty_id" => 1,
                "departement_name" => "S-1 Bahasa dan Sastra Indonesia"
            ],
            [
                "id" => 73,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Fisika"
            ],
            [
                "id" => 74,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Pancasila dan Kewarganegaraan"
            ],
            [
                "id" => 75,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Luar Biasa"
            ],
            [
                "id" => 76,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Teknik Mesin"
            ],
            [
                "id" => 77,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Guru Sekolah Dasar"
            ],
            [
                "id" => 78,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Teknik Bangunan"
            ],
            [
                "id" => 79,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Ekonomi"
            ],
            [
                "id" => 80,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Administrasi Perkantoran"
            ],
            [
                "id" => 81,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Matematika"
            ],
            [
                "id" => 82,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Sosiologi Antropologi"
            ],
            [
                "id" => 83,
                "faculty_id" => 1,
                "departement_name" => "S-1 Bimbingan Konseling"
            ],
            [
                "id" => 84,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Akuntansi"
            ],
            [
                "id" => 85,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Geografi"
            ],
            [
                "id" => 86,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Seni Rupa"
            ],
            [
                "id" => 87,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Kimia"
            ],
            [
                "id" => 88,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Biologi"
            ],
            [
                "id" => 89,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Bahasa Jawa"
            ],
            [
                "id" => 90,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Teknik Informatika dan Komputer"
            ],
            [
                "id" => 91,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Bahasa Inggris"
            ],
            [
                "id" => 92,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Guru Pendidikan Anak Usia Dini"
            ],
            [
                "id" => 93,
                "faculty_id" => 1,
                "departement_name" => "S-1 Pendidikan Ilmu Pengetahuan Alam"
            ],
            [
                "id" => 94,
                "faculty_id" => 2,
                "departement_name" => "S-1 Ilmu Sejarah"
            ],
            [
                "id" => 95,
                "faculty_id" => 2,
                "departement_name" => "S-1 Sastra Daerah/Jawa"
            ],
            [
                "id" => 96,
                "faculty_id" => 2,
                "departement_name" => "S-1 Sastra Indonesia"
            ],
            [
                "id" => 97,
                "faculty_id" => 2,
                "departement_name" => "S-1 Sastra Arab"
            ],
            [
                "id" => 98,
                "faculty_id" => 2,
                "departement_name" => "S-1 Sastra Inggris"
            ],
            [
                "id" => 99,
                "faculty_id" => 3,
                "departement_name" => "S-1 Akuntansi"
            ],
            [
                "id" => 100,
                "faculty_id" => 3,
                "departement_name" => "S-1 Manajemen"
            ],
            [
                "id" => 101,
                "faculty_id" => 3,
                "departement_name" => "S-1 Ekonomi Pembangunan"
            ],
            [
                "id" => 102,
                "faculty_id" => 4,
                "departement_name" => "S-1 Ilmu Komunikasi"
            ],
            [
                "id" => 103,
                "faculty_id" => 4,
                "departement_name" => "S-1 Sosiologi"
            ],
            [
                "id" => 104,
                "faculty_id" => 4,
                "departement_name" => "S-1 Hubungan Internasional"
            ],
            [
                "id" => 105,
                "faculty_id" => 5,
                "departement_name" => "S-1 Ilmu Hukum"
            ],
            [
                "id" => 106,
                "faculty_id" => 6,
                "departement_name" => "S-1 Agribisnis"
            ],
            [
                "id" => 107,
                "faculty_id" => 6,
                "departement_name" => "S-1 Penyuluhan dan Komunikasi Pertanian"
            ],
            [
                "id" => 108,
                "faculty_id" => 6,
                "departement_name" => "S-1 Ilmu Tanah"
            ],
            [
                "id" => 109,
                "faculty_id" => 6,
                "departement_name" => "S-1 Ilmu Peternakan"
            ],
            [
                "id" => 110,
                "faculty_id" => 6,
                "departement_name" => "S-1 Agroteknologi"
            ],
            [
                "id" => 111,
                "faculty_id" => 6,
                "departement_name" => "S-1 Ilmu Teknologi Pangan"
            ],
            [
                "id" => 112,
                "faculty_id" => 6,
                "departement_name" => "S-1 Pengelolaan Hutan"
            ],
            [
                "id" => 113,
                "faculty_id" => 7,
                "departement_name" => "S-1 Kedokteran"
            ],
            [
                "id" => 114,
                "faculty_id" => 7,
                "departement_name" => "S-1 Psikologi"
            ],
            [
                "id" => 115,
                "faculty_id" => 7,
                "departement_name" => "D-4 Kebidanan"
            ],
            [
                "id" => 116,
                "faculty_id" => 8,
                "departement_name" => "S-1 Teknik Sipil"
            ],
            [
                "id" => 117,
                "faculty_id" => 8,
                "departement_name" => "S-1 Teknik Mesin"
            ],
            [
                "id" => 118,
                "faculty_id" => 8,
                "departement_name" => "S-1 Arsitektur"
            ],
            [
                "id" => 119,
                "faculty_id" => 8,
                "departement_name" => "S-1 Teknik Industri"
            ],
            [
                "id" => 120,
                "faculty_id" => 8,
                "departement_name" => "S-1 Perencanaan Wilayah dan Kota"
            ],
            [
                "id" => 121,
                "faculty_id" => 8,
                "departement_name" => "S-1 Teknik Kimia"
            ],
            [
                "id" => 122,
                "faculty_id" => 8,
                "departement_name" => "S-1 Teknik Elektro"
            ],
            [
                "id" => 123,
                "faculty_id" => 9,
                "departement_name" => "S-1 Fisika"
            ],
            [
                "id" => 124,
                "faculty_id" => 9,
                "departement_name" => "S-1 Biologi"
            ],
            [
                "id" => 125,
                "faculty_id" => 9,
                "departement_name" => "S-1 Kimia"
            ],
            [
                "id" => 126,
                "faculty_id" => 9,
                "departement_name" => "S-1 Informatika"
            ],
            [
                "id" => 127,
                "faculty_id" => 9,
                "departement_name" => "S-1 Matematika"
            ],
            [
                "id" => 128,
                "faculty_id" => 9,
                "departement_name" => "S-1 Statistika"
            ],
            [
                "id" => 129,
                "faculty_id" => 9,
                "departement_name" => "S-1 Farmasi"
            ],
            [
                "id" => 130,
                "faculty_id" => 9,
                "departement_name" => "S-1 Ilmu Lingkungan"
            ],
            [
                "id" => 131,
                "faculty_id" => 12,
                "departement_name" => "S-1 Desain Komunikasi Visual"
            ],
            [
                "id" => 132,
                "faculty_id" => 12,
                "departement_name" => "S-1 Kriya Seni"
            ],
            [
                "id" => 133,
                "faculty_id" => 12,
                "departement_name" => "S-1 Desain Interior"
            ],
            [
                "id" => 134,
                "faculty_id" => 12,
                "departement_name" => "S-1 Seni Rupa Murni"
            ],
            [
                "id" => 135,
                "faculty_id" => 10,
                "departement_name" => "S-1 Pendidikan Jasmani, Kesehatan dan Rekreasi"
            ],
            [
                "id" => 136,
                "faculty_id" => 10,
                "departement_name" => "S-1 Pendidikan Kepelatihan Olahraga"
            ],
            [
                "id" => 137,
                "faculty_id" => 13,
                "departement_name" => "D-4 Keselamatan dan Kesehatan Kerja"
            ],
            [
                "id" => 138,
                "faculty_id" => 13,
                "departement_name" => "D-4 Studi Demografi dan Pencatatan Sipil"
            ],
            [
                "id" => 139,
                "faculty_id" => 13,
                "departement_name" => "D-3 Manajemen Pemasaran"
            ],
            [
                "id" => 140,
                "faculty_id" => 13,
                "departement_name" => "D-3 Perpajakan"
            ],
            [
                "id" => 141,
                "faculty_id" => 13,
                "departement_name" => "D-3 Akuntansi"
            ],
            [
                "id" => 142,
                "faculty_id" => 13,
                "departement_name" => "D-3 Keuangan dan Perbankan"
            ],
            [
                "id" => 143,
                "faculty_id" => 13,
                "departement_name" => "D-3 Manajemen Bisnis"
            ],
            [
                "id" => 144,
                "faculty_id" => 13,
                "departement_name" => "D-3 Manajemen Perdagangan"
            ],
            [
                "id" => 145,
                "faculty_id" => 13,
                "departement_name" => "D-3 Komunikasi Terapan"
            ],
            [
                "id" => 146,
                "faculty_id" => 13,
                "departement_name" => "D-3 Agribisnis"
            ],
            [
                "id" => 147,
                "faculty_id" => 13,
                "departement_name" => "D-3 Kebidanan"
            ],
            [
                "id" => 148,
                "faculty_id" => 13,
                "departement_name" => "D-3 Bahasa Inggris"
            ],
            [
                "id" => 149,
                "faculty_id" => 13,
                "departement_name" => "D-3 Usaha Perjalanan Wisata"
            ],
            [
                "id" => 150,
                "faculty_id" => 13,
                "departement_name" => "D-3 Bahasa Mandarin"
            ],
            [
                "id" => 151,
                "faculty_id" => 13,
                "departement_name" => "D-3 Manajemen Administrasi"
            ],
            [
                "id" => 152,
                "faculty_id" => 13,
                "departement_name" => "D-3 Perpustakaan"
            ],
            [
                "id" => 153,
                "faculty_id" => 13,
                "departement_name" => "D-3 Teknologi Hasil Pertanian"
            ],
            [
                "id" => 154,
                "faculty_id" => 13,
                "departement_name" => "D-3 Teknik Mesin"
            ],
            [
                "id" => 155,
                "faculty_id" => 13,
                "departement_name" => "D-3 Teknik Kimia"
            ],
            [
                "id" => 156,
                "faculty_id" => 13,
                "departement_name" => "D-3 Teknik Sipil"
            ],
            [
                "id" => 157,
                "faculty_id" => 13,
                "departement_name" => "D-3 Budidaya Ternak"
            ],
            [
                "id" => 158,
                "faculty_id" => 13,
                "departement_name" => "D-3 Farmasi"
            ],
            [
                "id" => 159,
                "faculty_id" => 13,
                "departement_name" => "D-3 Teknik Informatika"
            ],
            [
                "id" => 160,
                "faculty_id" => 13,
                "departement_name" => "D-3 Desain Komunikasi Visual"
            ]
        ];
        DB::table('departements')->insert($departements);
    }
}
