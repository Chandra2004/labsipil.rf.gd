<?php

namespace Database\Seeders;

use Faker\Factory;
use TheFramework\Database\Seeder;
use TheFramework\Helpers\Helper;
use TheFramework\Models\Core\FacultyModel;

class Seeder_2025_09_22_143315_ProgramStudiesSeeder {
    protected $facultyModel;

    public function __construct() {
        $this->facultyModel = new FacultyModel();
    }

    public function run() {
        $fti = $this->facultyModel->query()->where('code_faculty', '=', 'FTI')->first();
        $ftsp = $this->facultyModel->query()->where('code_faculty', '=', 'FTSP')->first();
        $fteti = $this->facultyModel->query()->where('code_faculty', '=', 'FTETI')->first();

        $faker = Factory::create();

        $studies = [
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Teknik Mesin',
                'educational_level' => 'S1',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Teknik Industri',
                'educational_level' => 'S1',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Teknik Kimia',
                'educational_level' => 'S1',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Teknik Pertambangan',
                'educational_level' => 'S1',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Teknik Perkapalan',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fti['uid'],
                'name_study' => 'Magister Teknik Industri',
                'educational_level' => 'S2',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $ftsp['uid'],
                'name_study' => 'Teknik Sipil',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $ftsp['uid'],
                'name_study' => 'Arsitektur',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $ftsp['uid'],
                'name_study' => 'Teknik Lingkungan',
                'educational_level' => 'S1',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $ftsp['uid'],
                'name_study' => 'Magister Teknik Lingkungan',
                'educational_level' => 'S2',
                'acreditation_study' => 'Baik Sekali',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fteti['uid'],
                'name_study' => 'Teknik Elektro',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fteti['uid'],
                'name_study' => 'Teknik Informatika',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
            [
                'uid' => Helper::uuid(),
                'faculty_uid' => $fteti['uid'],
                'name_study' => 'Sistem Informasi',
                'educational_level' => 'S1',
                'acreditation_study' => 'B',
            ],
        ];

        Seeder::setTable('program_studies');
        Seeder::create($studies);
    }
}
