<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->delete();
  
        $csvFile = fopen(base_path("database/data/districts.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                District::create([
                    "id" => $data['0'],
                    "regency_id" => $data['1'],
                    "name" => $data['2']
                ]);
                // id,regency_id,name    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
