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
        DB::table('users')->insert([
            'name' => 'Alumni Pertama',
            'email' => 'alumni@domain.com',
            'nik' => '28051999',
            'password' => Hash::make('12345678'),
        ]);
    }
}
