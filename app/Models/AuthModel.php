<?php

namespace ITATS\PraktikumTeknikSipil\Models;

use ITATS\PraktikumTeknikSipil\App\CacheManager;
use ITATS\PraktikumTeknikSipil\App\Database;
use ITATS\PraktikumTeknikSipil\App\Config;
use ITATS\PraktikumTeknikSipil\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use ITATS\PraktikumTeknikSipil\Helpers\Helper;

class AuthModel extends Database {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function registerUser($npmMahasiswa, $fullNameMahasiswa, $phoneMahasiswa, $emailMahasiswa, $passwordMahasiswa, $initials) {
        // Cek email
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE email = :email");
        $this->db->bind(':email', $emailMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'email_exists';
        }

        // Cek nomor telepon
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE phone = :phone");
        $this->db->bind(':phone', $phoneMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'phone_exists';
        }

        // Cek NPM
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE npm_nip = :npm");
        $this->db->bind(':npm', $npmMahasiswa);
        $result = $this->db->single();
        if ($result && $result['count'] > 0) {
            return 'npm_exists';
        }

        // Insert User
        $passwordMahasiswa = password_hash($passwordMahasiswa, PASSWORD_BCRYPT);

        $this->db->query("INSERT INTO users (uid, full_name, phone, email, password, npm_nip, role_uid, initials) VALUES (:uid, :full_name, :phone, :email, :password, :npm_nip, :role_uid, :initials)");
        $this->db->bind(':uid', Helper::generateUUID(10));
        $this->db->bind(':full_name', $fullNameMahasiswa);
        $this->db->bind(':phone', $phoneMahasiswa);
        $this->db->bind(':email', $emailMahasiswa);
        $this->db->bind(':password', $passwordMahasiswa);
        $this->db->bind(':npm_nip', $npmMahasiswa);
        $this->db->bind(':role_uid', 'azJw5fNCEX');
        $this->db->bind(':initials', $initials);


        return $this->db->execute();
    }

    public function loginUser($identyfier, $password) {
        $this->db->query("
            SELECT users.*, roles.role_name AS role_name
            FROM users
            JOIN roles ON users.role_uid = roles.uid
            WHERE users.email = :email OR users.npm_nip = :npm_nip
        ");
        $this->db->bind(':email', $identyfier);
        $this->db->bind(':npm_nip', $identyfier);
        $user = $this->db->single();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}