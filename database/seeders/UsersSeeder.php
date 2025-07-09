<?php

namespace Database\Seeders;

use ITATS\PraktikumTeknikSipil\App\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Faker\Factory;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use ITATS\PraktikumTeknikSipil\Models\Seeders\Users;

class UsersSeeder
{
    private $encryptionKey;

    public function __construct()
    {
        Config::loadEnv();
        $keyString = Config::get('ENCRYPTION_KEY');
        if (!$keyString) {
            throw new \Exception('Encryption key not configured.');
        }
        $this->encryptionKey = Key::loadFromAsciiSafeString($keyString);
    }

    public function run()
    {
        $users = [
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Chandra Tri Antomo',
                'phone' => '081234567890',
                'email' => 's@gmail.com',
                'password' => password_hash('superAdmin123', PASSWORD_BCRYPT),
                'npm_nip' => '06.2024.1.07780',
                'role_uid' => 'SWjtFccjC7',
                'initials' => 'SA'
            ],
            [
                'uid' => Helper::generateUUID(10),
                'full_name' => 'Brian Yudha A P',
                'phone' => '08590901234',
                'email' => 'p@gmail.com',
                'password' => password_hash('praktikan123123', PASSWORD_BCRYPT),
                'npm_nip' => '06.2024.1.07781',
                'role_uid' => 'azJw5fNCEX',
                'initials' => 'P'
            ],
        ];

        foreach ($users as $user) {
            Users::create($user);
        }
    }
}
