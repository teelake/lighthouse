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
        // Admin views (except auth) use the admin layout
        if (strpos($viewName, 'admin/') === 0 && strpos($viewName, 'admin/auth/') !== 0 && strpos($viewName, 'admin/errors/') !== 0) {
            ob_start();
            $role = $_SESSION['user_role'] ?? 'member';
            $data['isAdmin'] = $role === 'admin';
            $data['isEditor'] = in_array($role, ['editor', 'admin']);
            extract($data);
            require $viewFile;
            $content = ob_get_clean();
            extract($data);
            require APP_PATH . '/views/layouts/admin.php';
            return;
        }
        require $viewFile;
    }

    public function escape($s)
    {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }
}
