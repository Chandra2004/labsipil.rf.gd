<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class DashboardController
{
    public function praktikanDashboard() {
        View::render('dashboard.praktikan.home', [
            'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
            'roleName' => $_SESSION['user']['role_name']
        ]);
    }
    public function superAdminDashboard() {
        View::render('dashboard.superadmin.home', [
            'title' => 'Dashboard Home | Praktikum Teknik Sipil ITATS',
            'roleName' => $_SESSION['user']['role_name']
        ]);
    }
}
