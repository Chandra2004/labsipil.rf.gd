<?php

namespace TheFramework\Http\Controllers\Dashboard;

use Exception;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Controller;
use TheFramework\Models\Core\CourseModel;
use TheFramework\Models\Core\FacultyModel;
use TheFramework\Models\Core\UserModel;

class DashboardController extends Controller
{
    private $dataUser;
    private $users;
    private $faculties;
    private $courses;

    public function __construct()
    {
        $this->dataUser = Helper::session_get('user');
        $this->faculties = new FacultyModel();
        $this->users = new UserModel();
        $this->courses = new CourseModel();
    }

    public function Dashboard()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.base.base', [
            'notification' => $notification,
            'title' => $this->dataUser['full_name'] . ' | Dashboard Home | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser
        ]);
    }

    public function Profile()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.profile.profile', [
            'notification' => $notification,
            'title' => $this->dataUser['full_name'] . ' | Profile | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
            'faculties' => $this->faculties->query()->get(),
            'programStudies' => $this->faculties->query()->table('program_studies')->get()
        ]);
    }

    public function Courses()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.courses.courses', [
            'notification' => $notification,
            'title' => 'Courses | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
            'users' => $this->users->query()->select(['users.*', 'roles.role_name'])->table('users')->join('roles', 'users.role_uid', '=', 'roles.uid')->where('roles.role_name', '=', 'Koordinator')->get(),
            'programStudies' => $this->faculties->query()->table('program_studies')->get(),
            'courses' => $this->courses
                ->query()
                ->select(['courses.*', 'users.full_name AS author_name', 'program_studies.name_study AS study_name'])
                ->join('users', 'courses.author_course', '=', 'users.uid')
                ->join('program_studies', 'courses.study_course', '=', 'program_studies.uid')
                ->where('program_studies.uid', '=', $this->dataUser['study_uid'])
                ->with(['sessions'])
                ->get(),
        ]);
    }

    public function Modules()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.modules.modules', [
            'notification' => $notification,
            'title' => 'Modules | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
            'users' => $this->users->query()->select(['users.*', 'roles.role_name'])->table('users')->join('roles', 'users.role_uid', '=', 'roles.uid')->where('roles.role_name', '=', 'Koordinator')->get(),
            'programStudies' => $this->faculties->query()->table('program_studies')->get(),
            'courses' => $this->courses
                ->query()
                ->select([
                    'courses.*',
                    'users.full_name AS author_name',
                    'program_studies.name_study AS study_name'
                ])
                ->join('users', 'courses.author_course', '=', 'users.uid')
                ->join('program_studies', 'courses.study_course', '=', 'program_studies.uid')
                ->where('program_studies.uid', '=', $this->dataUser['study_uid'])
                ->with(['modules'])
                ->get(),
        ]);
    }

    public function CourseApproval()
    {
        $notification = Helper::get_flash('notification');
        $pembimbings = $this->users->query()->select(['users.*', 'roles.role_name'])->table('users')->join('roles', 'users.role_uid', '=', 'roles.uid')->where('roles.role_name', '=', 'Pembimbing')->get();
        $asistens = $this->users->query()->select(['users.*', 'roles.role_name'])->table('users')->join('roles', 'users.role_uid', '=', 'roles.uid')->where('roles.role_name', '=', 'Asisten')->get();
        $courses = $this->courses
            ->query()
            ->select([
                'courses.*',
                'users.full_name AS author_name',
                'program_studies.name_study AS study_name',
            ])
            ->join('users', 'courses.author_course', '=', 'users.uid')
            ->join('program_studies', 'courses.study_course', '=', 'program_studies.uid')
            ->where('program_studies.uid', '=', $this->dataUser['study_uid'])
            ->with([
                'sessions.participants.user',
                'sessions.participants.koordinator',
                'sessions.participants.asisten',
                'sessions.participants.pembimbing'
            ])
            ->map(function ($course) {
                $total = 0;
                $accepted = 0;

                if (!empty($course['sessions'])) {
                    foreach ($course['sessions'] as $session) {
                        if (!empty($session['participants'])) {
                            foreach ($session['participants'] as $participant) {
                                $total++;
                                if (($participant['status'] ?? null) === 'accepted') {
                                    $accepted++;
                                }
                            }
                        }
                    }
                }

                $course['total_participants'] = $total;
                $course['total_accepted'] = $accepted;

                return $course;
            });

        return View::render('Dashboard.pages.users.course-approval', [
            'notification' => $notification,
            'title' => 'Modules | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
            'courses' => $courses,
            'pembimbings' => $pembimbings,
            'asistens' => $asistens,
        ]);
    }


    public function PraktikanCourse()
    {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.courses.register-courses', [
            'notification' => $notification,
            'title' => 'Courses | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
            'users' => $this->users->query()->select(['users.*', 'roles.role_name'])->table('users')->join('roles', 'users.role_uid', '=', 'roles.uid')->where('roles.role_name', '=', 'Koordinator')->get(),
            'programStudies' => $this->faculties->query()->table('program_studies')->get(),
            'courses' => $this->courses
                ->query()
                ->select([
                    'courses.*',
                    'users.full_name AS author_name',
                    'program_studies.name_study AS study_name'
                ])
                ->join('users', 'courses.author_course', '=', 'users.uid')
                ->join('program_studies', 'courses.study_course', '=', 'program_studies.uid')
                ->where('program_studies.uid', '=', $this->dataUser['study_uid'])
                ->with(['sessions.participants'])
                ->get()
        ]);
    }

    public function PraktikanCard() {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.courses.card', [
            'notification' => $notification,
            'title' => 'Card | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
        ]);
    }

    public function PraktikanHistory() {
        $notification = Helper::get_flash('notification');

        return View::render('Dashboard.pages.courses.history', [
            'notification' => $notification,
            'title' => 'Card | Praktikum Teknik Sipil ITATS',

            'user' => $this->dataUser,
        ]);
    }
}
