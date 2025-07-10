<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class SuperAdminController
{
    private $dashboardController;
    private $linkDashboard;

    public function __construct()
    {
        $this->dashboardController = new DashboardController();
        $this->linkDashboard = $this->dashboardController->LinkDashboard();
    }

    public function index()
    {
        $notification = Helper::get_flash('notification');
        View::render('dashboard.superadmin.home', [
            'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
            'notification' => $notification,
            'link' => $this->linkDashboard,

            'fullName' => $_SESSION['user']['full_name'],
            'email' => $_SESSION['user']['email'],
            'initials' => $_SESSION['user']['initials'],
            'roleName' => $_SESSION['user']['role_name']
        ]);
    }
}
