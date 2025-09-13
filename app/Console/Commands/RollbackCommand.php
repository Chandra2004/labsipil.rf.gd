<?php
namespace TheFramework\Console\Commands;

use Throwable;
use TheFramework\Console\CommandInterface;

class RollbackCommand implements CommandInterface
{
    public function getName(): string
    {
        return 'migrate:rollback';
    }

    public function getDescription(): string
    {
        return 'Membatalkan migrasi database dengan menjalankan method down() dari file migrasi secara berurutan (dari terbaru ke terlama).';
    }

    public function run(array $args): void
    {
        // Tampilkan pesan konfirmasi
        $this->warn("Apakah kamu setuju untuk rollback semua tabel di database? (y/n): ");
        $handle = fopen("php://stdin", "r");
        $response = trim(fgets($handle));
        fclose($handle);

        // Hanya lanjutkan jika pengguna mengetik 'y' atau 'Y'
        if (strtolower($response) !== 'y') {
            $this->info("Rollback dibatalkan oleh pengguna.");
            return;
        }

        $migrationDir = BASE_PATH . '/database/migrations/';
        $migrationFiles = glob($migrationDir . '*.php');

        if (empty($migrationFiles)) {
            $this->warn("Tidak ada file migrasi ditemukan di $migrationDir");
            return;
        }

        $this->infoWait("Menjalankan rollback migrasi");

        // Urutkan dari besar ke kecil (rollback terbaru duluan)
        rsort($migrationFiles);

        foreach ($migrationFiles as $file) {
            $baseName = basename($file, '.php');
            $migrationClass = 'Database\\Migrations\\Migration_' . $baseName;

            if (!class_exists($migrationClass)) {
                require_once $file;
            }

            if (class_exists($migrationClass)) {
                try {
                    $migration = new $migrationClass();
                    $this->info("Rollback migrasi: $baseName...");
                    $migration->down();
                    $this->success("Rollback selesai untuk $baseName");
                } catch (Throwable $e) {
                    $this->error("Gagal rollback $baseName: " . $e->getMessage());
                    // lanjut ke file berikutnya
                }
            } else {
                $this->error("Kelas migrasi '$migrationClass' tidak ditemukan.");
            }
        }

        $this->success("Rollback migrasi selesai.");
    }

    /**
     * Output helper mirip Laravel
     */
    private function info(string $message): void
    {
        echo "\033[38;5;39m➤ INFO  {$message}\033[0m\n";
    }

    private function infoWait(string $message): void
    {
        echo "\033[38;5;39m➤ INFO  {$message}";
        for ($i = 0; $i < 3; $i++) {
            echo ".";
            usleep(200000);
        }
        echo "\033[0m\n";
    }

    private function warn(string $message): void
    {
        echo "\033[38;5;214m⚠ WARNING  {$message}\033[0m";
    }

    private function error(string $message): void
    {
        echo "\033[38;5;124m✖ ERROR  {$message}\033[0m\n";
    }

    private function success(string $message): void
    {
        echo "\033[38;5;28m★ SUCCESS  {$message}\033[0m\n";
    }
}
