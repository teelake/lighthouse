<?php
namespace App\Core;

class Application
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        $router = $this->router;
        require_once APP_PATH . '/config/routes.php';
    }

    public function run()
    {
        try {
            $url = $_SERVER['REQUEST_URI'] ?? '/';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
            $scriptDir = dirname($scriptName);
            $basePath = strpos($scriptName, '/public/') !== false ? str_replace('/public', '', $scriptDir) : $scriptDir;
            $basePath = str_replace('\\', '/', $basePath);

            if ($basePath !== '/' && strpos($url, $basePath) === 0) {
                $url = substr($url, strlen($basePath));
            }
            if (($pos = strpos($url, '?')) !== false) $url = substr($url, 0, $pos);
            $url = trim($url, '/');
            $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

            $this->router->dispatch($url, $method);
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    private function handleError($e)
    {
        $code = is_int($e->getCode()) && $e->getCode() >= 100 && $e->getCode() < 600 ? $e->getCode() : 500;
        http_response_code($code);
        if (APP_ENV === 'development') {
            echo "<h1>Error {$code}</h1><p>{$e->getMessage()}</p><pre>{$e->getTraceAsString()}</pre>";
        } else {
            if ($code === 404 && file_exists(APP_PATH . '/views/errors/404.php')) {
                require APP_PATH . '/views/errors/404.php';
            } elseif (file_exists(APP_PATH . '/views/errors/500.php')) {
                require APP_PATH . '/views/errors/500.php';
            } else {
                echo "<h1>Error</h1><p>An error occurred.</p>";
            }
        }
    }
}
