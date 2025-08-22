<?php
namespace TheFramework\Console\Commands;

use TheFramework\Console\CommandInterface;

class SeedCommand implements CommandInterface {
    public function getName(): string {
        return 'seed';
    }

    public function getDescription(): string {
        return 'Menjalankan seeder database';
    }

    public function run(array $args): void {
        echo "\033[38;5;39m➤ INFO  Menjalankan seeder";
        for ($i = 0; $i < 3; $i++) {
            echo ".";
            usleep(200000);
        }
        echo "\033[0m\n";
    
        $seedersPath = BASE_PATH . '/database/seeders';
        foreach (glob($seedersPath . '/*Seeder.php') as $file) {
            require_once $file;
            $className = 'Database\\Seeders\\' . basename($file, '.php');
            if (class_exists($className)) {
                $seeder = new $className();
                if (method_exists($seeder, 'run')) {
                    $seeder->run();
                }
            }
        }
    
        echo "\033[38;5;28m★ SUCCESS  Seeder selesai\033[0m\n";
    }
    
}