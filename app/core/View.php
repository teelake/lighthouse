<?php
namespace App\Core;

class View
{
    private $data = [];

    public function render($viewName, $data = [])
    {
        $this->data = $data;
        extract($data);
        $viewFile = APP_PATH . '/views/' . str_replace('.', '/', $viewName) . '.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("View not found: {$viewName}");
        }
        require $viewFile;
    }

    public function escape($s)
    {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }
}
