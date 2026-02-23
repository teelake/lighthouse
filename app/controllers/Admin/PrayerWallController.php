<?php
namespace App\Controllers\Admin;

use App\Models\PrayerRequest;
use App\Models\PrayerWall;
use App\Models\User;

class PrayerWallController extends BaseController
{
    public function index()
    {
        $this->requireAuth();
        $role = $_SESSION['user_role'] ?? '';

        if ($role === 'member') {
            $this->showMemberWall();
            return;
        }

        $this->requireEditor();
        $this->showManagementView();
    }

    private function showMemberWall(): void
    {
        $posts = (new PrayerWall())->findAll([], 'created_at DESC', 50);
        $users = [];
        if (!empty($posts)) {
            $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
            foreach ($userIds as $id) {
                $u = (new User())->find($id);
                if ($u) $users[$id] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }

        $this->render('admin/prayer-wall/member', [
            'pageTitle' => 'Prayer Wall',
            'pageHeading' => 'Prayer Wall',
            'currentPage' => 'prayer-wall',
            'posts' => $posts,
            'users' => $users,
            'posted' => isset($_GET['posted']),
            'error' => $_GET['error'] ?? null,
        ]);
    }

    private function showManagementView(): void
    {
        $requests = (new PrayerRequest())->findAll([], 'created_at DESC', 50);
        $posts = (new PrayerWall())->findAll([], 'created_at DESC', 50);
        $users = [];
        if (!empty($posts)) {
            $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
            foreach ($userIds as $id) {
                $u = (new User())->find($id);
                if ($u) $users[$id] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }

        $this->render('admin/prayer-wall/index', [
            'pageTitle' => 'Prayer Wall',
            'pageHeading' => 'Prayer Wall',
            'currentPage' => 'prayer-wall',
            'requests' => $requests,
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function wallPost()
    {
        $this->requireAuth();
        if (($_SESSION['user_role'] ?? '') !== 'member') {
            $this->unauthorized();
        }
        if (!csrf_verify()) {
            $this->redirectAdmin('prayer-wall?error=csrf');
        }
        $request = trim($this->post('request', ''));
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        if ($request === '') {
            $this->redirectAdmin('prayer-wall?error=empty');
        }
        try {
            (new PrayerWall())->create([
                'user_id' => $_SESSION['user_id'],
                'request' => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirectAdmin('prayer-wall?posted=1');
        } catch (\Throwable $e) {
            $this->redirectAdmin('prayer-wall?error=post');
        }
    }

    public function deleteRequest()
    {
        $this->requireAdmin();
        if (!csrf_verify()) return $this->redirectAdmin('prayer-wall');
        $id = (int)($this->params['id'] ?? 0);
        if ($id) (new PrayerRequest())->delete($id);
        $this->redirectAdmin('prayer-wall');
    }

    public function deletePost()
    {
        $this->requireAdmin();
        if (!csrf_verify()) return $this->redirectAdmin('prayer-wall');
        $id = (int)($this->params['id'] ?? 0);
        if ($id) (new PrayerWall())->delete($id);
        $this->redirectAdmin('prayer-wall');
    }
}
