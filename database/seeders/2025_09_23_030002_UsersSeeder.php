<?php

namespace Database\Seeders;

use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;
use TheFramework\Models\Core\RolesModel;

class Seeder_2025_09_23_030002_UsersSeeder {
    private $rolesModel;

    public function __construct()
    {
        $this->rolesModel = new RolesModel();
    }

    public function run()
    {
        $faker = Factory::create('id_ID');

        $rolesSuperAdmin = $this->rolesModel->query()->where('role_name', '=', 'SuperAdmin')->first();
        $rolesKoordinator = $this->rolesModel->query()->where('role_name', '=', 'Koordinator')->first();
        $rolesPembimbing = $this->rolesModel->query()->where('role_name', '=', 'Pembimbing')->first();
        $rolesAsisten = $this->rolesModel->query()->where('role_name', '=', 'Asisten')->first();
        $rolesPraktikan = $this->rolesModel->query()->where('role_name', '=', 'Praktikan')->first();

        Seeder::setTable('users');

        Seeder::create([
            // SUPERADMIN
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Super Admin Chandra',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'chandra@gmail.com',
                'initials'      => 'CA',
                'role_uid'      => $rolesSuperAdmin['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Super Admin Tio',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'tio@gmail.com',
                'initials'      => 'T',
                'role_uid'      => $rolesSuperAdmin['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],

            // KOORDINATOR
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Koordinator Brian',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'brian@gmail.com',
                'initials'      => 'B',
                'role_uid'      => $rolesKoordinator['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Koordinator Farrel',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'farrel@gmail.com',
                'initials'      => 'F',
                'role_uid'      => $rolesKoordinator['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],

            // PEMBIMBING
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Pembimbing Wawan',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'wawan@gmail.com',
                'initials'      => 'W',
                'role_uid'      => $rolesPembimbing['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Pembimbing Mada',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'mada@gmail.com',
                'initials'      => 'M',
                'role_uid'      => $rolesPembimbing['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],

            // ASISTEN
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Asisten Rizal',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'rizal@gmail.com',
                'initials'      => 'R',
                'role_uid'      => $rolesAsisten['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Asisten Nabel',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'nabel@gmail.com',
                'initials'      => 'N',
                'role_uid'      => $rolesAsisten['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],

            // PRAKTIKAN
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Praktikan Haza',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'haza@gmail.com',
                'initials'      => 'H',
                'role_uid'      => $rolesPraktikan['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
            [
                'uid'           => Helper::uuid(),
                'full_name'     => 'Praktikan Nabil',
                'phone_number'  => $faker->phoneNumber(),
                'password'      => Helper::hash_password('28092004'),
                'email'         => 'nabil@gmail.com',
                'initials'      => 'NB',
                'role_uid'      => $rolesPraktikan['uid'],
                'id_card'       => Helper::uuid(),
                'status'        => '1'
            ],
        ]);
    }
}
