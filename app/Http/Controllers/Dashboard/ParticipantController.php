<?php

// namespace TheFramework\Http\Controllers\Dashboard;

// use Exception;
// use TheFramework\App\Validator;
// use TheFramework\App\View;
// use TheFramework\Helpers\Helper;
// use TheFramework\Http\Controllers\Controller;
// use TheFramework\Models\Core\CourseModel;
// use TheFramework\Models\Core\ParticipantModel;
// use TheFramework\Models\Core\SessionModel;
// use TheFramework\Models\Core\UserModel;

// class ParticipantController extends Controller
// {
//     private $userModel;
//     private $courseModel;
//     private $sessionModel;
//     private $participantModel;

//     public function __construct()
//     {
//         $this->userModel = new UserModel();
//         $this->courseModel = new CourseModel();
//         $this->sessionModel = new SessionModel();
//         $this->participantModel = new ParticipantModel();
//     }

//     public function RegisterCourse($userUid, $courseUid)
//     {
//         if (Helper::is_post() && Helper::is_csrf()) {
//             $validator = new Validator();
//             $isValid = $validator->validate(
//                 $_POST,
//                 [
//                     'uid_session' => 'required',
//                 ],
//                 [
//                     'uid_session' => 'Sesi',
//                 ]
//             );

//             if (!$isValid) {
//                 $error = $validator->firstError();
//                 return Helper::redirect('/dashboard/courses/register', 'error', 'Validasi gagal: ' . $error);
//             }

//             try {
//                 $data = [
//                     'uid' => Helper::uuid(),
//                     'user_uid' => $userUid,
//                     'course_uid' => $courseUid,
//                     'session_uid' => $_POST['uid_session']
//                 ];

//                 $resultParticipant = $this->participantModel->CreateParticipant($data);

//                 $errorMessages = [
//                     'user_not_exist'            => 'Pengguna tidak ditemukan',
//                     'session_close'             => 'Sesi sudah tertutup',
//                     'course_not_exist'          => 'Praktikum tidak ditemukan',
//                     'session_not_exist'         => 'Sesi tidak ditemukan',
//                     'exists'                    => 'Anda sudah mendaftar di praktikum ini',
//                     'quota_full'                => 'Kuota kelas sudah penuh, pendaftaran ditolak',
//                     'no_asisten_available'      => 'Tidak bisa mendaftar karena tidak adanya asisten',
//                     'no_pembimbing_available'   => 'Tidak bisa mendaftar karena tidak adanya pembimbing'
//                 ];

//                 if (!is_array($resultParticipant) && isset($errorMessages[$resultParticipant])) {
//                     $msg = $errorMessages[$resultParticipant];
//                     return Helper::redirect('/dashboard/courses/register', 'error', $msg);
//                 }

//                 return Helper::redirect('/dashboard/courses/register', 'success', 'Sukses mendaftar. Mohon untuk menunggu konfirmasi dari Koordinator');
//             } catch (Exception $e) {
//                 return Helper::redirect('/dashboard/courses/register', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
//             }
//         }
//     }

//     public function UpdateRegisterCourse($participantUid, $participantUserUid)
//     {
//         if (!Helper::is_post() || !Helper::is_csrf()) {
//             return Helper::redirect('/dashboard/users/approval', 'error', 'Request tidak valid.');
//         }

//         $status = $_POST['action'] ?? '';
//         $validator = new Validator();

//         if (empty($participantUid) || empty($participantUserUid)) {
//             return Helper::redirect('/dashboard/users/approval', 'error', 'Validasi gagal: UID tidak lengkap.');
//         }

//         $rules = [];
//         $labels = [];

//         if (in_array($status, ['accepted', 'rejected'])) {
//             $rules = ['action' => 'required'];
//             $labels = ['action' => 'Status'];
//         } else {
//             $rules = [
//                 'asisten' => 'required',
//                 'pembimbing' => 'required',
//             ];
//             $labels = [
//                 'asisten' => 'Asisten praktikum',
//                 'pembimbing' => 'Pembimbing praktikum',
//             ];
//         }

//         if (!$validator->validate($_POST, $rules, $labels)) {
//             $error = $validator->firstError();
//             return Helper::redirect('/dashboard/users/approval', 'error', 'Validasi gagal: ' . $error);
//         }

//         $data = [];
//         if (in_array($status, ['accepted', 'rejected'])) {
//             $data = [
//                 'uid' => $participantUid,
//                 'user_uid' => $participantUserUid,
//                 'status' => $status
//             ];
//         } else {
//             $data = [
//                 'uid' => $participantUid,
//                 'user_uid' => $participantUserUid,
//                 'asisten_uid' => $_POST['asisten'],
//                 'pembimbing_uid' => $_POST['pembimbing']
//             ];
//         }

//         if ($status == 'rejected') {
//             try {
//                 $data = $this->participantModel->query()->where('uid', '=', $data['uid'])->where('user_uid', '=', $data['user_uid'])->first();

//                 $data = [
//                     'uid' => $data['uid'] ?? null,
//                     'user_uid' => $data['user_uid'] ?? null,
//                     'course_uid' => $data['course_uid'] ?? null,
//                     'session_uid' => $data['session_uid'] ?? null
//                 ];

//                 $resultParticipant = $this->participantModel->DeleteParticipant($data);

//                 $errorMessages = [
//                     'user_not_exist'            => 'Pengguna tidak ditemukan',
//                     'course_not_exist'          => 'Praktikum tidak ditemukan',
//                     'session_not_exist'         => 'Sesi tidak ditemukan',
//                     'user_not_registered'       => 'Anda tidak berada di daftar praktikum dan sesi ini'
//                 ];

//                 if (!is_array($resultParticipant) && isset($errorMessages[$resultParticipant])) {
//                     $msg = $errorMessages[$resultParticipant];
//                     return Helper::redirect('/dashboard/users/approval', 'error', $msg);
//                 }

//                 return Helper::redirect('/dashboard/users/approval', 'success', 'Berhasil untuk membatalkan pendaftaran.');
//             } catch (Exception $e) {
//                 return Helper::redirect('/dashboard/users/approval', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
//             }
//         }

//         try {
//             $resultParticipant = $this->participantModel->UpdateParticipant($data);

//             $errorMessages = [
//                 'user_not_exist'            => 'Pengguna tidak ditemukan',
//                 'course_not_exist'          => 'Praktikum tidak ditemukan',
//                 'session_not_exist'         => 'Sesi tidak ditemukan',
//                 'user_not_registered'       => 'Anda tidak berada di daftar praktikum dan sesi ini'
//             ];

//             if (!is_array($resultParticipant) && isset($errorMessages[$resultParticipant])) {
//                 $msg = $errorMessages[$resultParticipant];
//                 return Helper::redirect('/dashboard/users/approval', 'error', $msg);
//             }

//             return Helper::redirect('/dashboard/users/approval', 'success', 'Berhasil memperbarui');
//         } catch (Exception $e) {
//             return Helper::redirect('/dashboard/users/approval', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
//         }
//     }

//     public function DeleteRegisterCourse($userUid, $courseUid, $sessionUid)
//     {

//         if (Helper::is_post() && Helper::is_csrf()) {
//             if (empty($userUid) || empty($courseUid) || empty($sessionUid)) {
//                 return Helper::redirect('/dashboard/courses/register', 'error', 'Terjadi kesalahan: Parameter tidak ditemukan');
//             }

//             try {
//                 $data = $this
//                     ->participantModel
//                     ->query()
//                     ->where('user_uid', '=', $userUid)
//                     ->where('course_uid', '=', $courseUid)
//                     ->where('session_uid', '=', $sessionUid)
//                     ->first();

//                 $resultParticipant = $this->participantModel->DeleteParticipant($data);

//                 $errorMessages = [
//                     'user_not_exist'            => 'Pengguna tidak ditemukan',
//                     'course_not_exist'          => 'Praktikum tidak ditemukan',
//                     'session_not_exist'         => 'Sesi tidak ditemukan',
//                     'user_not_registered'       => 'Anda tidak berada di daftar praktikum dan sesi ini',
//                 ];

//                 if (!is_array($resultParticipant) && isset($errorMessages[$resultParticipant])) {
//                     $msg = $errorMessages[$resultParticipant];
//                     return Helper::redirect('/dashboard/courses/register', 'error', $msg);
//                 }

//                 return Helper::redirect('/dashboard/courses/register', 'success', 'Berhasil untuk membatalkan pendaftaran.');
//             } catch (Exception $e) {
//                 return Helper::redirect('/dashboard/courses/register', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
//             }
//         }
//     }
// }


namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\Validator;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\UserModel;
use TheFramework\Models\Core\CourseModel;
use TheFramework\Models\Core\SessionModel;
use TheFramework\Models\Core\ParticipantModel;

class ParticipantController extends Controller
{
    private UserModel $userModel;
    private CourseModel $courseModel;
    private SessionModel $sessionModel;
    private ParticipantModel $participantModel;

    private const ERROR_MESSAGES = [
        'user_not_exist'          => 'Pengguna tidak ditemukan.',
        'session_close'           => 'Sesi sudah tertutup.',
        'course_not_exist'        => 'Praktikum tidak ditemukan.',
        'session_not_exist'       => 'Sesi tidak ditemukan.',
        'exists'                  => 'Anda sudah mendaftar di praktikum ini.',
        'quota_full'              => 'Kuota kelas sudah penuh, pendaftaran ditolak.',
        'no_asisten_available'    => 'Tidak bisa mendaftar karena tidak adanya asisten.',
        'no_pembimbing_available' => 'Tidak bisa mendaftar karena tidak adanya pembimbing.',
        'user_not_registered'     => 'Anda tidak berada di daftar praktikum dan sesi ini.'
    ];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->sessionModel = new SessionModel();
        $this->participantModel = new ParticipantModel();
    }

    public function RegisterCourse(string $userUid, string $courseUid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/courses/register', 'error', 'Permintaan tidak valid.');
        }

        $validator = new Validator();
        $isValid = $validator->validate($_POST, [
            'uid_session' => 'required'
        ], ['uid_session' => 'Sesi']);

        if (!$isValid) {
            $error = $validator->firstError();
            return Helper::redirect('/dashboard/courses/register', 'error', 'Validasi gagal: ' . $error);
        }

        try {
            $data = [
                'uid' => Helper::uuid(),
                'user_uid' => $userUid,
                'course_uid' => $courseUid,
                'session_uid' => $_POST['uid_session']
            ];

            $result = $this->participantModel->CreateParticipant($data);
            return $this->handleResult($result, '/dashboard/courses/register', 'Sukses mendaftar. Mohon menunggu konfirmasi dari Koordinator.');
        } catch (Exception $e) {
            return $this->handleException($e, '/dashboard/courses/register');
        }
    }

    public function UpdateRegisterCourse(string $participantUid, string $participantUserUid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/users/approval', 'error', 'Permintaan tidak valid.');
        }

        if (empty($participantUid) || empty($participantUserUid)) {
            return Helper::redirect('/dashboard/users/approval', 'error', 'UID tidak lengkap.');
        }

        $status = $_POST['action'] ?? '';
        $validator = new Validator();

        $rules = [];
        $labels = [];

        if (in_array($status, ['accepted', 'rejected'])) {
            $rules = ['action' => 'required'];
            $labels = ['action' => 'Status'];
        } else {
            $rules = ['asisten' => 'required', 'pembimbing' => 'required'];
            $labels = ['asisten' => 'Asisten praktikum', 'pembimbing' => 'Pembimbing praktikum'];
        }

        if (!$validator->validate($_POST, $rules, $labels)) {
            $error = $validator->firstError();
            return Helper::redirect('/dashboard/users/approval', 'error', 'Validasi gagal: ' . $error);
        }

        if ($status === 'rejected') {
            return $this->handleRejection($participantUid, $participantUserUid);
        }

        $data = in_array($status, ['accepted', 'rejected'])
            ? ['uid' => $participantUid, 'user_uid' => $participantUserUid, 'status' => $status]
            : [
                'uid' => $participantUid,
                'user_uid' => $participantUserUid,
                'asisten_uid' => $_POST['asisten'],
                'pembimbing_uid' => $_POST['pembimbing']
            ];

        try {
            $result = $this->participantModel->UpdateParticipant($data);
            return $this->handleResult($result, '/dashboard/users/approval', 'Berhasil memperbarui.');
        } catch (Exception $e) {
            return $this->handleException($e, '/dashboard/users/approval');
        }
    }

    public function DeleteRegisterCourse(string $userUid, string $courseUid, string $sessionUid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/courses/register', 'error', 'Permintaan tidak valid.');
        }

        if (empty($userUid) || empty($courseUid) || empty($sessionUid)) {
            return Helper::redirect('/dashboard/courses/register', 'error', 'Parameter tidak lengkap.');
        }

        try {
            $data = $this->participantModel
                ->query()
                ->where('user_uid', '=', $userUid)
                ->where('course_uid', '=', $courseUid)
                ->where('session_uid', '=', $sessionUid)
                ->first();

            if(isset($data) && $data['status'] == 'accepted') {
                return Helper::redirect('/dashboard/courses/register', 'error', 'Anda sudah disetujui di praktikum dan sesi ini.');
            }

            $result = $this->participantModel->DeleteParticipant($data);
            return $this->handleResult($result, '/dashboard/courses/register', 'Berhasil membatalkan pendaftaran.');
        } catch (Exception $e) {
            return $this->handleException($e, '/dashboard/courses/register');
        }
    }

    private function handleRejection(string $participantUid, string $participantUserUid)
    {
        try {
            $data = $this->participantModel
                ->query()
                ->where('uid', '=', $participantUid)
                ->where('user_uid', '=', $participantUserUid)
                ->first();

            $participantData = [
                'uid' => $data['uid'] ?? null,
                'user_uid' => $data['user_uid'] ?? null,
                'course_uid' => $data['course_uid'] ?? null,
                'session_uid' => $data['session_uid'] ?? null
            ];

            $result = $this->participantModel->DeleteParticipant($participantData);
            return $this->handleResult($result, '/dashboard/users/approval', 'Berhasil membatalkan pendaftaran.');
        } catch (Exception $e) {
            return $this->handleException($e, '/dashboard/users/approval');
        }
    }

    private function handleResult($result, string $redirectPath, string $successMessage)
    {
        if (!is_array($result) && isset(self::ERROR_MESSAGES[$result])) {
            $msg = self::ERROR_MESSAGES[$result];
            return Helper::redirect($redirectPath, 'error', $msg);
        }
        return Helper::redirect($redirectPath, 'success', $successMessage);
    }

    private function handleException(Exception $e, string $redirectPath)
    {
        return Helper::redirect($redirectPath, 'error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

