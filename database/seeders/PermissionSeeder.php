<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'computer_device',
                'description' => 'Can manage computer devices',
            ],
            [
                'id' => 2,
                'name' => 'computer_device_detail',
                'description' => 'Can view detail of devices',
            ],
            [
                'id' => 3,
                'name' => 'computer_group',
                'description' => 'Can manage device groups',
            ],
            [
                'id' => 4,
                'name' => 'software_osupdate',
                'description' => 'Can manage OS Update',
            ],
            [
                'id' => 5,
                'name' => 'software_licensedSoftware',
                'description' => 'Can manage software license',
            ],
            [
                'id' => 6,
                'name' => 'software_prohibitedSoftware',
                'description' => 'Can manage software restriction',
            ],
            [
                'id' => 7,
                'name' => 'software_deployment',
                'description' => 'Can manage software deployment',
            ],
            [
                'id' => 8,
                'name' => 'log_auth',
                'description' => 'Can view authentication log',
            ],
            [
                'id' => 9,
                'name' => 'log_activity',
                'description' => 'Can view activity log',
            ],
            [
                'id' => 10,
                'name' => 'agent',
                'description' => 'Can manage agents',
            ],
            [
                'id' => 11,
                'name' => 'agent_deployment',
                'description' => 'Can deploy agents',
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
