<?php
namespace App\Core;

abstract class Controller
{
    protected $params = [];
    protected $view;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->view = new View();
    }

    protected function render($viewName, $data = [])
    {
        $this->view->render($viewName, $data);
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect($url)
    {
        if (strpos($url, 'http') !== 0) {
            $url = rtrim(BASE_URL, '/') . '/' . ltrim($url, '/');
        }
        header("Location: {$url}");
        exit;
    }

    protected function post($key = null, $default = null)
    {
        return $key === null ? $_POST : ($_POST[$key] ?? $default);
    }

    protected function get($key = null, $default = null)
    {
        return $key === null ? $_GET : ($_GET[$key] ?? $default);
    }

    protected function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/admin/login');
        }
    }
}
