<?php

namespace Database\Seeders;

use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;

class Seeder_2025_09_22_143254_FacultiesSeeder
{

    public function run()
    {
        $faker = Factory::create();
        Seeder::setTable('faculties');

        $faculties = [
            [
                'uid' => Helper::uuid(),
                'code_faculty' => 'FTI',
                'name_faculty' => 'Fakultas Teknologi Industri',
                'description_faculty' => 'Fakultas yang berfokus pada pengembangan teknologi dan inovasi di bidang industri, mencakup teknik mesin, teknik kimia, dan manajemen industri.'
            ],
            [
                'uid' => Helper::uuid(),
                'code_faculty' => 'FTSP',
                'name_faculty' => 'Fakultas Teknik Sipil dan Perencanaan',
                'description_faculty' => 'Fakultas yang mengkhususkan diri dalam perencanaan dan pembangunan infrastruktur, seperti teknik sipil, arsitektur, dan perencanaan wilayah kota.'
            ],
            [
                'uid' => Helper::uuid(),
                'code_faculty' => 'FTETI',
                'name_faculty' => 'Fakultas Teknik Elektro dan Teknologi Informasi',
                'description_faculty' => 'Fakultas yang menawarkan program studi di bidang teknik elektro, teknologi informasi, dan sistem komputer untuk mendukung kemajuan teknologi digital.'
            ],
        ];

        Seeder::create($faculties);
    }
}
