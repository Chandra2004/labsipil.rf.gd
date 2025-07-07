<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/app/Helpers/helpers.php';

    define('ROOT_DIR', __DIR__); // Sudah di root hosting

    use ITATS\PraktikumTeknikSipil\BladeInit;
    use ITATS\PraktikumTeknikSipil\App\Config;
    use ITATS\PraktikumTeknikSipil\App\Router;
    use ITATS\PraktikumTeknikSipil\App\SessionManager;

    //Middleware
    use ITATS\PraktikumTeknikSipil\Middleware\AuthMiddleware;
    use ITATS\PraktikumTeknikSipil\Middleware\CsrfMiddleware;
    use ITATS\PraktikumTeknikSipil\Middleware\WAFMiddleware;
    use ITATS\PraktikumTeknikSipil\Middleware\RoleMiddleware;

    // Validator Middleware
    use ITATS\PraktikumTeknikSipil\Middleware\Validator\RegisterValidator;
    use ITATS\PraktikumTeknikSipil\Middleware\Validator\LoginValidator;
    
    // Controllers
    use ITATS\PraktikumTeknikSipil\Http\Controllers\Auth\RegisterController;
    use ITATS\PraktikumTeknikSipil\Http\Controllers\Auth\LoginController;
    use ITATS\PraktikumTeknikSipil\Http\Controllers\Homepage\HomeController;
    use ITATS\PraktikumTeknikSipil\Http\Controllers\News\NewsController;
    use ITATS\PraktikumTeknikSipil\Http\Controllers\Dashboard\DashboardController;

    SessionManager::startSecureSession();
    Config::loadEnv();
    
    header('X-Powered-By: Native-Chandra');
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    
    // Jalankan router
    CsrfMiddleware::generateToken();

    Router::add('GET', '/', HomeController::class, 'index', [WAFMiddleware::class]);

    Router::add('GET', '/news', NewsController::class, 'index', [WAFMiddleware::class]);
    Router::add('GET', '/news/page/{page}', NewsController::class, 'index', [WAFMiddleware::class]);
    Router::add('GET', '/news/{category}/{id}/{slug}', NewsController::class, 'detail', [WAFMiddleware::class]);

    Router::add('GET', '/login', LoginController::class, 'index', [WAFMiddleware::class]);
    Router::add('POST', '/login/auth', LoginController::class, 'loginUser', [WAFMiddleware::class, CsrfMiddleware::class, LoginValidator::class]);
    
    Router::add('GET', '/register', RegisterController::class, 'index', [WAFMiddleware::class]);
    Router::add('POST', '/register/auth', RegisterController::class, 'registerUser', [WAFMiddleware::class, CsrfMiddleware::class, RegisterValidator::class]);

    Router::add('GET', '/dashboard/superadmin', DashboardController::class, 'superAdminDashboard', [
        AuthMiddleware::class,
        WAFMiddleware::class,
        [RoleMiddleware::class, ['SuperAdmin']]
    ]);

    Router::add('GET', '/dashboard/praktikan', DashboardController::class, 'praktikanDashboard', [
        AuthMiddleware::class,
        WAFMiddleware::class,
        [RoleMiddleware::class, ['Praktikan']]
    ]);
    
    Router::add('GET', '/logout', LoginController::class, 'logout', [WAFMiddleware::class]);

    BladeInit::init();
    Router::run();
?>
