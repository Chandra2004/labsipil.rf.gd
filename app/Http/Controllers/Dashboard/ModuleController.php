<?php

namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\Validator;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\ModuleModel;

class ModuleController extends Controller
{
    private ModuleModel $moduleModel;

    private const ERROR_MESSAGES = [
        'code_exist'        => 'Kode modul sudah ada.',
        'name_exist'        => 'Nama modul sudah ada.',
        'time_exist'        => 'Tanggal modul harus lebih baru dari modul sebelumnya.',
        'module_not_exists' => 'Modul tidak ditemukan.',
        false               => 'Tidak ada yang dihapus.',
    ];

    public function __construct(?ModuleModel $moduleModel = null)
    {
        $this->moduleModel = $moduleModel ?? new ModuleModel();
    }

    public function CreateModule($uid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/modules', 'error', 'Permintaan tidak valid.');
        }

        $data = $this->validateAndPrepareData($uid);
        if (!$data) return null;

        try {
            $result = $this->moduleModel->CreateModule($data);
            return $this->handleResult($result, "{$data['name_module']} berhasil dibuat.");
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function UpdateModule($uid, $courseUid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/modules', 'error', 'Permintaan tidak valid.');
        }

        $data = $this->validateAndPrepareData($courseUid, $uid);
        if (!$data) return null;

        try {
            $result = $this->moduleModel->UpdateModule($data);
            return $this->handleResult($result, "{$data['name_module']} berhasil diperbarui.");
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function DeleteModule($uid)
    {
        if (!Helper::is_post() || !Helper::is_csrf()) {
            return Helper::redirect('/dashboard/modules', 'error', 'Permintaan tidak valid.');
        }

        $validator = new Validator();
        $isValid = $validator->validate($_POST, [
            'name_module' => 'required|min:3|max:100',
        ], ['name_module' => 'Nama modul']);

        if (!$isValid) {
            return Helper::redirect('/dashboard/modules', 'error', 'Validasi gagal: ' . $validator->firstError());
        }

        try {
            $data = [
                'uid' => $uid,
                'name_module' => $_POST['name_module']
            ];

            $result = $this->moduleModel->DeleteModule($data);
            return $this->handleResult($result, "{$data['name_module']} berhasil dihapus.");
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    private function validateAndPrepareData($courseUid, $uid = null): ?array
    {
        $validator = new Validator();
        $isValid = $validator->validate($_POST, [
            'code_module' => 'required|min:1|max:10',
            'name_module' => 'required|min:3|max:100',
            'description_module' => 'required',
            'date_module' => 'required',
        ], [
            'code_module' => 'Kode modul',
            'name_module' => 'Nama modul',
            'description_module' => 'Deskripsi modul',
            'date_module' => 'Tanggal modul',
        ]);

        if (!$isValid) {
            $error = $validator->firstError();
            Helper::redirect('/dashboard/modules', 'error', 'Validasi gagal: ' . $error);
            return null;
        }

        return [
            'uid' => $uid ?? Helper::uuid(),
            'course_uid' => $courseUid,
            'file_module' => $_FILES['file_module']['name'] ?? null,
            'code_module' => $_POST['code_module'],
            'name_module' => $_POST['name_module'],
            'description_module' => $_POST['description_module'],
            'date_module' => $_POST['date_module'],
        ];
    }

    private function handleResult($result, string $successMessage)
    {
        if (!is_array($result) && isset(self::ERROR_MESSAGES[$result])) {
            $msg = self::ERROR_MESSAGES[$result];
            return Helper::redirect('/dashboard/modules', 'error', $msg);
        }
        return Helper::redirect('/dashboard/modules', 'success', $successMessage);
    }

    private function handleException(Exception $e)
    {
        return Helper::redirect('/dashboard/modules', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
