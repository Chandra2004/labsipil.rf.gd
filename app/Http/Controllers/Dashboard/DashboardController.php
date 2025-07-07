<?php

namespace ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard;

use ITATS\PraktikumTeknikSipil\App\{Config, Database, View, CacheManager};
use ITATS\PraktikumTeknikSipil\Helpers\Helper;
use Exception;

class DashboardController
{
    public function praktikanDashboard() {
        View::render('dashboard.praktikan.home', []);
    }
    public function superAdminDashboard() {
        View::render('dashboard.superadmin.home', []);
    }
}
