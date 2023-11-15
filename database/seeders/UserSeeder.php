<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'phonenumber' => '0123456789',
            'password' => Hash::make('12#qwE'),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
