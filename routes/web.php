<?php
// ROUTER
use TheFramework\App\Router;

// MIDDLEWARE
use TheFramework\Middleware\WAFMiddleware;
use TheFramework\Middleware\CsrfMiddleware;
use TheFramework\Middleware\AuthMiddleware;
use TheFramework\Middleware\RoleMiddleware;

// CONTROLLER
use TheFramework\Http\Controllers\Guest\HomeController;
use TheFramework\Http\Controllers\Auth\LoginController;
use TheFramework\Http\Controllers\Auth\RegisterController;
use TheFramework\Http\Controllers\Dashboard\CourseController;
use TheFramework\Http\Controllers\Dashboard\DashboardController;
use TheFramework\Http\Controllers\Dashboard\ModuleController;
use TheFramework\Http\Controllers\Dashboard\ParticipantController;
use TheFramework\Http\Controllers\Dashboard\ProfileController;
use TheFramework\Http\Controllers\Dashboard\SessionController;

Router::add('GET', '/', HomeController::class, 'Welcome', [WAFMiddleware::class]);
Router::add('GET', '/news', HomeController::class, 'News', [WAFMiddleware::class]);
Router::add('GET', '/news/page/{page}', HomeController::class, 'News', [WAFMiddleware::class]);
Router::add('GET', '/news/detail/title/{slug}/item/{uid}', HomeController::class, 'DetailNews', [WAFMiddleware::class]);

Router::add('GET', '/login', LoginController::class, 'Login', [WAFMiddleware::class]);
Router::add('POST', '/login/auth', LoginController::class, 'AuthLogin', [WAFMiddleware::class, CsrfMiddleware::class]);

Router::add('GET', '/logout/id/{id}/user/{uid}', LoginController::class, 'AuthLogout', [WAFMiddleware::class]);

Router::add('GET', '/register', RegisterController::class, 'Register', [WAFMiddleware::class]);
Router::add('POST', '/register/auth', RegisterController::class, 'AuthRegister', [WAFMiddleware::class, CsrfMiddleware::class]);

Router::add('GET', '/dashboard', DashboardController::class, 'Dashboard', [WAFMiddleware::class, AuthMiddleware::class, [RoleMiddleware::class, ['SuperAdmin', 'Koordinator', 'Asisten', 'Pembimbing', 'Praktikan']]]);
Router::group(
    [
        'prefix' => '/dashboard',
        'middleware' => [
            AuthMiddleware::class,
            CsrfMiddleware::class,
            WAFMiddleware::class,
        ]
    ],
    function () {
        // Praktikan
        Router::add('GET', '/courses/register', DashboardController::class, 'PraktikanCourse', [[RoleMiddleware::class, ['Praktikan']]]);
        Router::add('POST', '/courses/register/{courseUid}/user/{userUid}', ParticipantController::class, 'RegisterCourse', [[RoleMiddleware::class, ['Praktikan']]]);
        Router::add('POST', '/courses/register/delete/user/{userUid}/course/{courseUid}/session/{sessionUid}', ParticipantController::class, 'DeleteRegisterCourse', [[RoleMiddleware::class, ['Praktikan']]]);
        
        Router::add('GET', '/courses/history', DashboardController::class, 'PraktikanHistory', [[RoleMiddleware::class, ['Praktikan']]]);
        Router::add('GET', '/courses/card', DashboardController::class, 'PraktikanCard', [[RoleMiddleware::class, ['Praktikan']]]);

        Router::add('GET', '/courses', DashboardController::class, 'Courses', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/courses/create/{uid}', CourseController::class, 'CreateCourse', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/courses/update/{uid}', CourseController::class, 'UpdateCourse', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/courses/delete/{uid}', CourseController::class, 'DeleteCourse', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);

        Router::add('POST', '/sessions/create/{uid}', SessionController::class, 'CreateSession', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/sessions/update/{uid}/course/{courseUid}', SessionController::class, 'UpdateSession', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/sessions/delete/{uid}', SessionController::class, 'DeleteSession', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        
        Router::add('GET', '/modules', DashboardController::class, 'Modules', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/modules/create/{uid}', ModuleController::class, 'CreateModule', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/modules/update/{uid}/course/{courseUid}', ModuleController::class, 'UpdateModule', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/modules/delete/{uid}', ModuleController::class, 'DeleteModule', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);

        Router::add('GET', '/users/approval', DashboardController::class, 'CourseApproval', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);
        Router::add('POST', '/users/approval/update/{participantUid}/{participantUserUid}', ParticipantController::class, 'UpdateRegisterCourse', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator']]]);

        Router::add('GET', '/profile', DashboardController::class, 'Profile', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator', 'Asisten', 'Pembimbing', 'Praktikan']]]);
        Router::add('POST', '/profile/update/photo/{uid}', ProfileController::class, 'UpdatePhoto', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator', 'Asisten', 'Pembimbing', 'Praktikan']]]);
        Router::add('POST', '/profile/update/data/{uid}', ProfileController::class, 'UpdateData', [[RoleMiddleware::class, ['SuperAdmin', 'Koordinator', 'Asisten', 'Pembimbing', 'Praktikan']]]);
    }
);