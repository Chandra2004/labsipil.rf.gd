<?php

namespace TheFramework\Http\Controllers\Auth;

use Exception;
use TheFramework\App\View;
use TheFramework\App\Validator;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\UserModel;

class LoginController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function Login()
    {
        $notification = Helper::get_flash('notification');

        if (!Helper::session_get('user')) {
            return View::render('Auth.pages.login', [
                'notification' => $notification,
                'title' => 'Login - Civil Praktikum Manager',
            ]);
        }

        return Helper::redirect('/dashboard', 'success', 'Anda sudah login');
    }

    public function AuthLogin()
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $validator = new Validator();
            $isValid = $validator->validate($_POST, [
                'identifier' => 'required|min:3|max:100',
                'password'   => 'required|min:6|max:50',
            ], [
                'identifier' => 'NPM/Email',
                'password'   => 'Kata Sandi',
            ]);

            if (!$isValid) {
                return Helper::redirect('/login', 'warning', $validator->firstError());
            }

            $data = [
                'identifier' => $_POST['identifier'],
                'password'   => $_POST['password'],
            ];

            try {
                $result = $this->userModel->AuthLogin($data);

                $errorMessages = [
                    'status_failed' => 'Status akun anda tidak aktif',
                    false           => 'Password anda salah',
                ];

                if (!is_array($result) && isset($errorMessages[$result])) {
                    return Helper::redirect('/login', 'error', $errorMessages[$result]);
                }

                Helper::session_write('user', $result, true);
                Helper::authToken($result['uid']);

                return Helper::redirect('/dashboard', 'success', $_SESSION['user']['full_name'] . ' selamat datang!');
            } catch (Exception $e) {
                return Helper::redirect('/login', 'error', $e->getMessage());
            }
        }
    }

    public function AuthLogout($id, $uid)
    {
        if ($id === (string) $_SESSION['user']['id'] && $uid === (string) $_SESSION['user']['uid']) {
            session_destroy();
            return Helper::redirect('/login', 'success', 'Logout berhasil');
        }

        return Helper::redirect('/dashboard', 'error', 'Tidak dapat logout');
    }
}
