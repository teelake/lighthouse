<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

/**
 * Base controller for admin - enforces auth and role checks
 * member: view-only (dashboard, limited)
 * editor: content management (sections, leaders, events, etc.) - no users/settings
 * admin: full access
 */
abstract class BaseController extends Controller
{
    protected function requireAuth()
    {
        parent::requireAuth();
    }

    /** Require at least editor role */
    protected function requireEditor()
    {
        $this->requireAuth();
        $role = $_SESSION['user_role'] ?? 'member';
        if (!in_array($role, ['editor', 'admin'])) {
            $this->unauthorized();
        }
    }

    /** Require admin role */
    protected function requireAdmin()
    {
        $this->requireAuth();
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            $this->unauthorized();
        }
    }

    protected function unauthorized()
    {
        http_response_code(403);
        $this->render('admin/errors/403');
        exit;
    }

    /** Redirect within admin */
    protected function redirectAdmin(string $path = '')
    {
        $this->redirect(function_exists('admin_url') ? admin_url($path) : '/admin/' . ltrim($path, '/'));
    }
}
