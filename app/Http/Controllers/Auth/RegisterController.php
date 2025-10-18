<?php

namespace TheFramework\Http\Controllers\Auth;

use Exception;
use TheFramework\App\Validator;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\RolesModel;
use TheFramework\Models\Core\UserModel;

class RegisterController extends Controller
{
    private RolesModel $rolesModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->rolesModel = new RolesModel();
        $this->userModel = new UserModel();
    }

    public function Register()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Auth.pages.register', [
            'notification' => $notification,
            'title' => 'Register - Civil Praktikum',
        ]);
    }

    public function AuthRegister()
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $roles = $this->rolesModel->query()->where('role_name', '=', 'Praktikan')->first();

            $validator = new Validator();
            $isValid = $validator->validate($_POST, [
                'npm'              => 'required|regex:/^\d{2}\.\d{4}\.\d\.\d{5}$/',
                'full_name'        => 'required|min:3|max:100',
                'phone'            => 'required',
                'email'            => 'required|email',
                'password'         => 'required|min:6',
                'password_confirm' => 'required|same:password',
            ], [
                'npm'              => 'NPM',
                'full_name'        => 'Nama Lengkap',
                'phone'            => 'Nomor Telepon',
                'email'            => 'Email',
                'password'         => 'Password',
                'password_confirm' => 'Konfirmasi Password',
            ]);

            if (!$isValid) {
                return Helper::redirect('/register', 'error', 'Validasi gagal: ' . $validator->firstError());
            }

            try {
                $initials = '';
                $words = explode(' ', $_POST['full_name']);
                if (!empty($words[0])) $initials .= strtoupper(substr($words[0], 0, 1));
                if (!empty($words[1])) $initials .= strtoupper(substr($words[1], 0, 1));

                $data = [
                    'uid'              => Helper::uuid(),
                    'full_name'        => $_POST['full_name'],
                    'phone_number'     => $_POST['phone'],
                    'semester'         => '1',
                    'password'         => Helper::hash_password($_POST['password']),
                    'email'            => $_POST['email'],
                    'student_staff_id' => $_POST['npm'],
                    'initials'         => $initials,
                    'role_uid'         => $roles['uid'],
                    'id_card'          => Helper::uuid(),
                    'status'           => '1',
                ];

                $result = $this->userModel->CreateUser($data);

                $errorMessages = [
                    'npm_exist'   => 'NPM sudah terdaftar.',
                    'phone_exist' => 'Nomor telepon sudah terdaftar.',
                    'email_exist' => 'Email sudah terdaftar.',
                    false         => 'Registrasi gagal.',
                ];

                if (!is_array($result) && isset($errorMessages[$result])) {
                    return Helper::redirect('/register', 'error', $errorMessages[$result]);
                }

                return Helper::redirect('/register', 'success', 'Berhasil melakukan registrasi.');
            } catch (Exception $e) {
                return Helper::redirect('/register', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return Helper::redirect('/register', 'warning', 'Akses tidak valid.');
    }
}