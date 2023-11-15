<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'id' => 1,
            'name' => 'OSVersion',
            'value' => '1.0',
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
