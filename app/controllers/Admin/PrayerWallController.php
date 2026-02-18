<?php
namespace App\Controllers\Admin;

use App\Models\PrayerRequest;
use App\Models\PrayerWall;
use App\Models\User;

class PrayerWallController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();

        $requests = (new PrayerRequest())->findAll([], 'created_at DESC', 50);
        $posts = (new PrayerWall())->findAll([], 'created_at DESC', 50);

        // Resolve user names for prayer wall posts
        $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
        $users = [];
        if (!empty($userIds)) {
            $userModel = new User();
            foreach ($userIds as $id) {
                $u = $userModel->find($id);
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
