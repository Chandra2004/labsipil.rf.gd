<?php

namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\Validator;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\CourseModel;
use TheFramework\Models\Core\ParticipantModel;
use TheFramework\Models\Core\UserModel;

class CourseController extends Controller
{
    private CourseModel $courseModel;
    private UserModel $userModel;
    private ParticipantModel $participantModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->userModel = new UserModel();
        $this->participantModel = new ParticipantModel();
    }

    private function validateCourseInput(array $input): bool
    {
        $validator = new Validator();
        return $validator->validate($input, [
            'code' => 'required|min:1|max:10',
            'title' => 'required|min:3|max:100',
            'study' => 'required',
            'semester' => 'required|integer|min:1|max:6',
            'author' => 'required',
            'description' => 'required'
        ], [
            'code' => 'Kode Praktikum',
            'title' => 'Nama Praktikum',
            'study' => 'Prodi',
            'semester' => 'Semester',
            'author' => 'Nama Pembimbing',
            'description' => 'Deskripsi Praktikum'
        ]);
    }

    private function checkUserAccess(string $uid)
    {
        return $this->userModel
            ->query()
            ->select(['users.*', 'roles.role_name'])
            ->join('roles', 'users.role_uid', '=', 'roles.uid')
            ->where('users.uid', '=', $uid)
            ->where('roles.role_name', '=', 'SuperAdmin')
            ->orWhere('roles.role_name', '=', 'Koordinator')
            ->first();
    }

    private function handleRedirect(string $route, string $status, string $message)
    {
        return Helper::redirect($route, $status, $message);
    }

    public function CreateCourse(string $uid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $validator = new Validator();

            if (!$this->validateCourseInput($_POST)) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $validator->firstError());
            }

            if (empty($this->checkUserAccess($uid))) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Anda tidak memiliki akses untuk membuat course ini.');
            }

            try {
                $data = $this->getCourseDataFromPost();
                $result = $this->courseModel->CreateCourse($data);

                $errorMessages = [
                    'code_exist' => 'Kode praktikum sudah ada.',
                    'name_exist' => 'Nama praktikum sudah ada.',
                ];

                if (!is_array($result) && isset($errorMessages[$result])) {
                    return $this->handleRedirect('/dashboard/courses', 'error', $errorMessages[$result]);
                }

                return $this->handleRedirect('/dashboard/courses', 'success', $data['name_course'] . ' course berhasil dibuat.');
            } catch (Exception $e) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    public function UpdateCourse(string $uid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $course = $this->courseModel->query()->where('uid', '=', $uid)->first();

            if (empty($course)) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Course tidak ditemukan.');
            }

            $validator = new Validator();

            if (!$this->validateCourseInput($_POST)) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $validator->firstError());
            }

            try {
                $data = $this->getCourseDataFromPost();
                $result = $this->courseModel->UpdateCourse($uid, $data);

                $errorMessages = [
                    'code_exist' => 'Kode praktikum sudah ada.',
                    'name_exist' => 'Nama praktikum sudah ada.',
                    false => 'Tidak ada perubahan yang dilakukan.'
                ];

                if (!is_array($result) && isset($errorMessages[$result])) {
                    return $this->handleRedirect('/dashboard/courses', 'error', $errorMessages[$result]);
                }

                return $this->handleRedirect('/dashboard/courses', 'success', $course['name_course'] . ' course berhasil diupdate menjadi ' . $data['name_course']);
            } catch (Exception $e) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    public function DeleteCourse(string $uid)
    {
        if (Helper::is_post() && Helper::is_csrf()) {
            $course = $this->courseModel
                ->query()
                ->where('uid', '=', $uid)
                ->where('name_course', '=', $_POST['title'])
                ->first();

            if (empty($course)) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Nama course tidak ada dan tidak valid.');
            }

            $validator = new Validator();

            if (!$validator->validate($_POST, ['title' => 'required|min:3|max:100'], ['title' => 'Nama Praktikum'])) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Validasi gagal: ' . $validator->firstError());
            }

            try {
                $data = [
                    'uid' => $uid,
                    'name_course' => $_POST['title']
                ];

                $result = $this->courseModel->DeleteCourse($data);

                if ($result === false) {
                    return $this->handleRedirect('/dashboard/courses', 'error', 'Tidak ada yang dihapus.');
                }

                return $this->handleRedirect('/dashboard/courses', 'success', $course['name_course'] . ' course berhasil dihapus.');
            } catch (Exception $e) {
                return $this->handleRedirect('/dashboard/courses', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    private function getCourseDataFromPost(): array
    {
        return [
            'uid' => Helper::uuid(),
            'code_course' => $_POST['code'],
            'name_course' => $_POST['title'],
            'study_course' => $_POST['study'],
            'semester_course' => $_POST['semester'],
            'author_course' => $_POST['author'],
            'description_course' => $_POST['description'],
            'link_course' => $_POST['link_course'] ?? null
        ];
    }
}
