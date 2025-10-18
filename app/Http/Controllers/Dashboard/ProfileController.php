<?php

namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\Validator;
use TheFramework\Helpers\Helper;
use TheFramework\Config\ImageHandler;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\UserModel;
use TheFramework\Models\Core\FacultyModel;

class ProfileController extends Controller
{
    private UserModel $userModel;
    private FacultyModel $facultyModel;

    private const ERROR_MESSAGES = [
        'npm_exist'   => 'NPM sudah terdaftar.',
        'phone_exist' => 'Nomor telepon sudah terdaftar.',
        'email_exist' => 'Email sudah terdaftar.',
        'dismatch'    => 'Fakultas dan Prodi harus berkesinambungan.',
        false         => 'Update gagal.',
    ];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->facultyModel = new FacultyModel();
    }

    public function UpdatePhoto(string $uid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/profile', 'error', 'Permintaan tidak valid.');
        }

        try {
            $user = $this->userModel->query()->where('uid', '=', $uid)->first();
            $uploadPhoto = ImageHandler::handleUploadToWebP($_FILES['avatar'], '/avatar', 1);

            if (ImageHandler::isError($uploadPhoto)) {
                $errorMessage = ImageHandler::getErrorMessage($uploadPhoto, ['size' => 1]);
                return Helper::redirect('/dashboard/profile', 'error', $errorMessage);
            }

            if (!empty($user['avatar'])) {
                ImageHandler::delete('/avatar', $user['avatar']);
            }

            $this->userModel->UpdateUser($uid, ['avatar' => $uploadPhoto]);
            Helper::session_write('user', ['avatar' => $uploadPhoto]);

            return Helper::redirect('/dashboard/profile', 'success', 'Foto profil berhasil diperbarui.');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function UpdateData(string $uid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/profile', 'error', 'Permintaan tidak valid.');
        }

        $validator = new Validator();
        $isValid = $validator->validate($_POST, [
            'name'         => 'required|min:3|max:100',
            'phone'        => 'required',
            'nomorKampus'  => 'required|regex:/^\d{2}\.\d{4}\.\d\.\d{5}$/',
            'semester'     => 'required|integer|min:1|max:6',
            'email'        => 'required|email',
        ], [
            'name'         => 'Nama Lengkap',
            'phone'        => 'Nomor Telepon',
            'nomorKampus'  => 'NIM/NPM',
            'semester'     => 'Semester',
            'email'        => 'Email',
        ]);

        if (!$isValid) {
            $error = $validator->firstError();
            return Helper::redirect('/dashboard/profile', 'error', 'Validasi gagal: ' . $error);
        }

        try {
            $initials = $this->generateInitials($_POST['name']);

            $data = [
                'full_name'        => $_POST['name'] ?? '',
                'phone_number'     => $_POST['phone'] ?? '',
                'faculty_uid'      => $_POST['fakultas'] ?? '',
                'study_uid'        => $_POST['prodi'] ?? '',
                'semester'         => $_POST['semester'] ?? '',
                'gender'           => $_POST['gender'] ?? '',
                'email'            => $_POST['email'] ?? '',
                'student_staff_id' => $_POST['nomorKampus'] ?? '',
                'initials'         => $initials,
            ];

            $result = $this->userModel->UpdateUser($uid, $data);

            if (!is_array($result) && isset(self::ERROR_MESSAGES[$result])) {
                $msg = self::ERROR_MESSAGES[$result];
                return Helper::redirect('/dashboard/profile', 'error', $msg);
            }

            Helper::session_write('user', [
                'full_name'        => $data['full_name'],
                'phone_number'     => $data['phone_number'],
                'student_staff_id' => $data['student_staff_id'],
                'email'            => $data['email'],
                'gender'           => $data['gender'],
                'faculty_uid'      => $data['faculty_uid'],
                'study_uid'        => $data['study_uid'],
                'semester'         => $data['semester'],
                'initials'         => $data['initials'],
            ]);

            return Helper::redirect('/dashboard/profile', 'success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    private function generateInitials(string $name): string
    {
        $words = explode(' ', trim($name));
        $initials = '';
        if (!empty($words[0])) $initials .= strtoupper(substr($words[0], 0, 1));
        if (!empty($words[1])) $initials .= strtoupper(substr($words[1], 0, 1));
        return $initials;
    }

    private function handleException(Exception $e)
    {
        return Helper::redirect('/dashboard/profile', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
