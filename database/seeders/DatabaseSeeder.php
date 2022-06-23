<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            TracerStudySeeder::class,
            TracerWorkSeeder::class,
            TracerEntrepreneurSeeder::class,
            FacultySeeder::class,
            DepartementSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
