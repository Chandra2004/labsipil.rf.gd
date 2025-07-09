<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Auth;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;
use ITATS\PraktikumTeknikSipil\Models\AuthModel;

class LoginController
{
        private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }
    public function index() {
        $notification = Helper::get_flash('notification');
        View::render('auth.login',[
            'notification' => $notification
        ]);
    }

    public function loginUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['loginUser'])) {
            return Helper::redirect('/login', 'error', 'Invalid request method.');
        }

        $identyfier = filter_input(INPUT_POST, 'identyfier', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

        if (empty($identyfier) || empty($password)) {
            return Helper::redirect('/login', 'error', 'Email and password are required.');
        }

        try {
            $user = $this->authModel->loginUser($identyfier, $password);
            if (!$user) {
                return Helper::redirect('/login', 'error', 'Invalid email or password.');
            }

            // Simpan session user
            $_SESSION['user'] = [
                'id' => $user['id'],
                'uid' => $user['uid'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'initials' => $user['initials'],
                'role_name' => $user['role_name'],
            ];

            // Update last activity & generate token
            $_SESSION['auth_token'] = hash('sha256', $_SESSION['user']['id'] . Config::get('APP_KEY'));

            // echo "role : " . $user['role_name'];
            // Redirect berdasarkan role
            if ($user['role_name'] === 'SuperAdmin') {
                return Helper::redirect('/dashboard/superadmin', 'success', 'Welcome, praktikan!');
            }
            if ($user['role_name'] === 'Praktikan') {
                return Helper::redirect('/dashboard/praktikan', 'success', 'Welcome, praktikan!');
            }

        } catch (Exception $e) {
            return Helper::redirect('/login', 'error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function logout() {
        session_destroy();
        return Helper::redirect('/', 'success', 'Logged out successfully.');
    }
}
