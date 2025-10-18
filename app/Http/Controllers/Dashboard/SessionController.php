<?php

namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\Validator;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\SessionModel;

class SessionController extends Controller
{
    private $sessionModel;

    public function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    private function validateSessionData()
    {
        $validator = new Validator();
        return $validator->validate(
            $_POST,
            [
                'code_session' => 'required|min:1|max:20',
                'name_session' => 'required|min:3|max:100',
                'start_session' => 'required',
                'end_session' => 'required',
                'kuota_session' => 'required|integer|min:1|max:100',
                'open_session' => 'required',
                'close_session' => 'required',
            ],
            [
                'code_session' => 'Kode sesi',
                'name_session' => 'Nama sesi',
                'start_session' => 'Tanggal mulai',
                'end_session' => 'Tanggal berakhir',
                'kuota_session' => 'Kuota sesi',
                'open_session' => 'Jam buka',
                'close_session' => 'Jam tutup'
            ]
        );
    }

    private function checkSessionData($data)
    {
        if ($data['start_session'] > $data['end_session']) {
            return 'Waktu mulai tidak boleh lebih besar dari Waktu berakhir.';
        }

        if ($data['kuota_session'] <= 0) {
            return 'Kuota sesi tidak kurang dari 0.';
        }

        if ($data['open_session'] > $data['close_session']) {
            return 'Tanggal buka tidak boleh lebih besar dari Tanggal tutup.';
        }

        return null;
    }

    private function handleSessionCreationOrUpdate($data, $isUpdate = false)
    {
        $result = $isUpdate ? $this->sessionModel->UpdateSession($data) : $this->sessionModel->CreateSession($data);

        $errorMessages = [
            'course_not_exists' => 'Kelas tidak ditemukan',
            'code_exist' => 'Kode sesi sudah digunakan.',
            'name_exist' => 'Nama sesi sudah digunakan.',
            'time_conflict' => 'Waktu sesi bertabrakan dengan sesi lain dalam kursus ini.',
            'session_not_exists' => 'Sesi tidak ditemukan',
        ];

        if (!is_array($result) && isset($errorMessages[$result])) {
            return Helper::redirect('/dashboard/courses', 'error', $errorMessages[$result]);
        }

        $action = $isUpdate ? 'diupdate' : 'dibuat';
        return Helper::redirect('/dashboard/courses', 'success', $data['name_session'] . " berhasil $action.");
    }

    public function CreateSession($uid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            if (!$this->validateSessionData()) {
                $error = (new Validator())->firstError();
                return Helper::redirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $error);
            }

            try {
                $data = [
                    'uid' => Helper::uuid(),
                    'course_uid' => $uid,
                    'code_session' => $_POST['code_session'],
                    'name_session' => $_POST['name_session'],
                    'start_session' => $_POST['start_session'],
                    'end_session' => $_POST['end_session'],
                    'kuota_session' => $_POST['kuota_session'],
                    'open_session' => $_POST['open_session'],
                    'close_session' => $_POST['close_session'],
                ];

                $errorMsg = $this->checkSessionData($data);
                if ($errorMsg) {
                    return Helper::redirect('/dashboard/courses', 'error', $errorMsg);
                }

                return $this->handleSessionCreationOrUpdate($data);
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    public function UpdateSession($uid, $courseUid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            if (!$this->validateSessionData()) {
                $error = (new Validator())->firstError();
                return Helper::redirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $error);
            }

            try {
                $data = [
                    'uid' => $uid,
                    'course_uid' => $courseUid,
                    'code_session' => $_POST['code_session'],
                    'name_session' => $_POST['name_session'],
                    'start_session' => $_POST['start_session'],
                    'end_session' => $_POST['end_session'],
                    'kuota_session' => $_POST['kuota_session'],
                    'open_session' => $_POST['open_session'],
                    'close_session' => $_POST['close_session'],
                ];

                $errorMsg = $this->checkSessionData($data);
                if ($errorMsg) {
                    return Helper::redirect('/dashboard/courses', 'error', $errorMsg);
                }

                return $this->handleSessionCreationOrUpdate($data, true);
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    public function DeleteSession($uid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $validator = new Validator();
            $isValid = $validator->validate(
                $_POST,
                ['name_session' => 'required|min:3|max:100'],
                ['name_session' => 'Sesi praktikum']
            );

            if (!$isValid) {
                return Helper::redirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $validator->firstError());
            }

            $session = $this->sessionModel->query()->where('uid', '=', $uid)->where('name_session', '=', $_POST['name_session'])->first();

            if (empty($session)) {
                return Helper::redirect('/dashboard/courses', 'error', 'Nama sesi tidak ada dan tidak valid.');
            }

            try {
                $data = ['uid' => $uid, 'name_session' => $_POST['name_session']];
                $resultSession = $this->sessionModel->DeleteSession($data);

                $errorMessages = [
                    false => 'Tidak ada yang dihapus'
                ];

                if (!is_array($resultSession) && isset($errorMessages[$resultSession])) {
                    return Helper::redirect('/dashboard/courses', 'error', $errorMessages[$resultSession]);
                }

                return Helper::redirect('/dashboard/courses', 'success', $session['name_session'] . ' berhasil dihapus.');
            } catch (Exception $e) {
                return Helper::redirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }
}