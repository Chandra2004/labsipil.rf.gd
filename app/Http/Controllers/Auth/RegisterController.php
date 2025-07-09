<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Auth;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Models\AuthModel;

class RegisterController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }
    public function index() {
        $notification = Helper::get_flash('notification');
        View::render('auth.register',[
            'notification' => $notification,
        ]);
    }

    public function registerUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['registerUser'])) {
            return Helper::redirect('/register', 'error', 'Invalid request method.');
        }

        $npmMahasiswa = filter_input(INPUT_POST, 'npm', FILTER_SANITIZE_SPECIAL_CHARS);
        $fullNameMahasiswa = filter_input(INPUT_POST, 'full-name', FILTER_SANITIZE_SPECIAL_CHARS);
        $phoneMahasiswa = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
        $emailMahasiswa = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $passwordMahasiswa = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
        $passwordConfirmMahasiswa = filter_input(INPUT_POST, 'password-confirm', FILTER_UNSAFE_RAW);

        $words = explode(' ', $fullNameMahasiswa);
        $initials = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $initials .= strtoupper(substr($words[1], 0, 1));
        }

        if ($passwordMahasiswa !== $passwordConfirmMahasiswa) {
            return Helper::redirect('/register', 'error', 'Passwords do not match.');
        }

        try {
            $result = $this->authModel->registerUser($npmMahasiswa, $fullNameMahasiswa, $phoneMahasiswa, $emailMahasiswa, $passwordMahasiswa, $initials);

            if ($result === 'email_exists') {
                return Helper::redirect('/register', 'error', 'Email sudah terdaftar.');
            } elseif ($result === 'phone_exists') {
                return Helper::redirect('/register', 'error', 'Nomor telepon sudah terdaftar.');
            } elseif ($result === 'npm_exists') {
                return Helper::redirect('/register', 'error', 'NPM sudah terdaftar.');
            } elseif ($result === false) {
                return Helper::redirect('/register', 'error', 'Registrasi gagal.');
            }

            return Helper::redirect('/login', 'success', 'Registrasi berhasil. Silakan login.');
        } catch (Exception $e) {
            return Helper::redirect('/register', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
