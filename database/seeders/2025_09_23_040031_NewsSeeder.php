<?php

namespace Database\Seeders;

use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;
use TheFramework\Models\Core\UserModel;

class Seeder_2025_09_23_040031_NewsSeeder
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function run()
    {
        $user = $this->userModel->query()
            ->select([
                'users.*',
                'roles.role_name AS role_name'
            ])
            ->table('users')
            ->join('roles', 'users.role_uid', '=', 'roles.uid')
            ->where('role_name', '=', 'Koordinator')
            ->get();

        $faker = Factory::create();
        Seeder::setTable('news');

        $categories = ['Pengumuman', 'Berita', 'Event'];
        $data = [];

        for ($i = 0; $i < 400; $i++) {
            $title = $faker->sentence(6);
            $data[] = [
                'uid' => Helper::uuid(),
                'category' => $faker->randomElement($categories),
                'title' => $title,
                'slug' => Helper::slugify($title),
                'description' => $faker->paragraphs(3, true),
                'author' => $faker->randomElement([$user[0]['uid'], $user[1]['uid']]),
                'date_time' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        Seeder::create($data);
    }
}
