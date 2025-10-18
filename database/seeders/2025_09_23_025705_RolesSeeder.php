<?php

namespace Database\Seeders;

use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;

class Seeder_2025_09_23_025705_RolesSeeder {

    public function run() {
        $faker = Factory::create();
        Seeder::setTable('roles');

        $roles = [
            [
                'uid' => Helper::uuid(),
                'role_name' => 'SuperAdmin',
                'role_description' => 'SuperAdmin'
            ],
            [
                'uid' => Helper::uuid(),
                'role_name' => 'Koordinator',
                'role_description' => 'Koordinator'
            ],
            [
                'uid' => Helper::uuid(),
                'role_name' => 'Pembimbing',
                'role_description' => 'Pembimbing'
            ],
            [
                'uid' => Helper::uuid(),
                'role_name' => 'Asisten',
                'role_description' => 'Asisten'
            ],
            [
                'uid' => Helper::uuid(),
                'role_name' => 'Praktikan',
                'role_description' => 'Praktikan'
            ]
        ];

        Seeder::create($roles);
    }
}
