<?php

namespace Database\Seeders;

use TheFramework\App\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;

class UserSeeder  {

    public function run() {
        $faker = Factory::create();
        Seeder::setTable('users');

        for($i = 0; $i < 10; $i++) {
            Seeder::create([
                ['name' => 'john_doe_' . $i, 'email' => $faker->email(), 'password' => Helper::hash_password('123456')]
            ]);
        }
    }
}
