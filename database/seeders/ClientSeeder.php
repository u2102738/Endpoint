<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'id' => 1,
                'auth_key' => '_jasmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'auth_key' => '_joseph',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
