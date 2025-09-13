<?php

namespace TheFramework\Console\Commands;

use Throwable;
use TheFramework\Console\CommandInterface;
use TheFramework\App\Database;
use TheFramework\App\Schema;

class RollbackCommand implements CommandInterface
{
    public function getName(): string
    {
        return 'migrate:rollback';
    }

    public function getDescription(): string
    {
        return 'Membatalkan semua migrasi berdasarkan urutan dari terbaru ke terlama';
    }

    public function run(array $args): void
    {
        $db = Database::getInstance();

        $this->info("Menyiapkan rollback migrasi");

        // Ambil daftar migrasi dari tabel migrations
        $migrations = $this->getMigrations($db);

        if (empty($migrations)) {
            $this->warn("Tidak ada migrasi yang ditemukan di tabel migrations.");
            return;
        }

        // Konfirmasi dari user
        $this->warn("Apakah kamu setuju untuk rollback semua tabel di database? (y/n): ");
        $handle = fopen("php://stdin", "r");
        $confirmation = trim(fgets($handle));
        fclose($handle);

        if (!in_array(strtolower($confirmation), ['y', 'yes'], true)) {
            $this->error("Rollback dibatalkan oleh pengguna.");
            return;
        }

        $this->infoWait("Menjalankan rollback migrasi");

        try {
            // Jalankan dari migrasi terbaru ke lama
            foreach (array_reverse($migrations) as $migration) {
                $className = $migration['migration'];

                try {
                    $class = "\\Database\\Migrations\\{$className}";
                    if (!class_exists($class)) {
                        $this->error("Class {$class} tidak ditemukan.");
                        continue;
                    }

                    $this->info("Menjalankan down() untuk: {$className}");
                    $instance = new $class();
                    $instance->down();

                    // Hapus record migrasi dari tabel
                    $db->query("DELETE FROM migrations WHERE migration = :migration");
                    $db->bind(':migration', $className);
                    $db->execute();

                    $this->success("Rollback {$className} berhasil.");
                } catch (Throwable $e) {
                    $this->error("Gagal rollback {$className}: " . $e->getMessage());
                }
            }

            $this->success("Rollback selesai.");
        } catch (Throwable $e) {
            $this->error("Terjadi kesalahan saat rollback: " . $e->getMessage());
        }
    }

    private function getMigrations($db): array
    {
        try {
            $db->query("SELECT migration FROM migrations ORDER BY id ASC");
            return $db->resultSet();
        } catch (Throwable $e) {
            return [];
        }
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
        echo "\033[38;5;214m⚠ WARNING  {$message}\033[0m\n";
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
