<?php

use TheFramework\Helpers\Helper;
use TheFramework\Http\Controllers\Services\ErrorController;

if (!function_exists('url')) {
    function url($path = '')
    {
        return Helper::url($path);
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $status = null, $message = null)
    {
        Helper::redirect($url, $status, $message);
    }
}

if (!function_exists('request')) {
    function request($key = null, $default = null)
    {
        return Helper::request($key, $default);
    }
}

if (!function_exists('set_flash')) {
    function set_flash($key, $message)
    {
        Helper::set_flash($key, $message);
    }
}

if (!function_exists('get_flash')) {
    function get_flash($key)
    {
        return Helper::get_flash($key);
    }
}

if (!function_exists('uuid')) {
    function uuid(int $length = 36)
    {
        return Helper::uuid($length);
    }
}

if (!function_exists('updateAt')) {
    function updateAt()
    {
        return Helper::updateAt();
    }
}

if (!function_exists('rupiah')) {
    function rupiah($number)
    {
        return Helper::rupiah($number);
    }
}

if (!function_exists('maintentance')) {
    function maintenance()
    {
        return ErrorController::maintenance();
    }
}
