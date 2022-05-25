<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin account
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@domain.com',
            'nik' => '-',
            'nim' => '-',
            'first' => 0,
            'completed' => 1,
            'validated' => 1,
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        // user account
        DB::table('users')->insert([
            'name' => 'Alumni Pertama',
            'email' => 'alumni@domain.com',
            'nik' => '28051999',
            'nim' => '17520241021',
            'validated' => 1,
            'password' => Hash::make('12345678'),
        ]);

    }
}
