<?php
namespace App\Core;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'load']);
    }

    public static function load($class)
    {
        $prefix = 'App\\';
        $baseDir = APP_PATH . '/';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) return;

        $relativeClass = substr($class, $len);
        $segments = explode('\\', $relativeClass);
        if (!empty($segments)) {
            $segments[0] = strtolower($segments[0]);
        }
        $file = $baseDir . implode('/', $segments) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
