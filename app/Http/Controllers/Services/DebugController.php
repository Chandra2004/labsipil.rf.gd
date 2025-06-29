<?php

namespace {{NAMESPACE}}\Http\Controllers\Services;

use {{NAMESPACE}}\App\{Config, Database, View, CacheManager};
use {{NAMESPACE}}\Helpers\Helper;
use Exception;

class DebugController
{
    public static function showException(\Throwable $e)
    {
        http_response_code(500);
        View::render('debug.exception', [
            'class' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    public static function showFatal(array $error)
    {
        http_response_code(500);
        View::render('debug.fatal', [
            'message' => $error['message'] ?? 'Fatal error',
            'file' => $error['file'] ?? 'unknown',
            'line' => $error['line'] ?? 'unknown',
        ]);
    }
}
