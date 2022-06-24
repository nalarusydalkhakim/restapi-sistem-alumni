<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regencies')->delete();
  
        $csvFile = fopen(base_path("database/data/regencies.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Regency::create([
                    "id" => $data['0'],
                    "province_id" => $data['1'],
                    "name" => $data['2'],
                ]);
                // id,province_id,nama   
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
