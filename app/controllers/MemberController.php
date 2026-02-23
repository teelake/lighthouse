<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\PrayerWall;
use App\Models\User;

/**
 * Member portal - requires login and role = 'member'.
 * Prayer Wall is a members-only digital space.
 */
class MemberController extends Controller
{
    private function requireMember(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $redirect = urlencode('members/prayer-wall');
            $loginUrl = (function_exists('admin_url') ? admin_url('login') : '/admin/login') . '?redirect=' . $redirect;
            $this->redirect($loginUrl);
        }
        $role = $_SESSION['user_role'] ?? '';
        if ($role !== 'member') {
            http_response_code(403);
            $this->render('members/forbidden');
            exit;
        }
    }

    public function prayerWall()
    {
        $this->requireMember();

        $wallPosts = (new PrayerWall())->findAll([], 'created_at DESC', 50);
        $wallUsers = [];
        if (!empty($wallPosts)) {
            $userIds = array_unique(array_filter(array_column($wallPosts, 'user_id')));
            foreach ($userIds as $uid) {
                $u = (new User())->find($uid);
                $wallUsers[$uid] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }

        $this->render('members/prayer-wall', [
            'pageTitle' => 'Prayer Wall - Member Portal',
            'wallPosts' => $wallPosts,
            'wallUsers' => $wallUsers,
            'posted' => isset($_GET['posted']),
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function wallPost()
    {
        $this->requireMember();

        if (!csrf_verify()) {
            $this->redirect(rtrim(BASE_URL, '/') . '/members/prayer-wall?error=csrf');
        }
        $request = trim($this->post('request', ''));
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        if ($request === '') {
            $this->redirect(rtrim(BASE_URL, '/') . '/members/prayer-wall?error=empty');
        }
        try {
            (new PrayerWall())->create([
                'user_id' => $_SESSION['user_id'],
                'request' => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirect(rtrim(BASE_URL, '/') . '/members/prayer-wall?posted=1');
        } catch (\Throwable $e) {
            $this->redirect(rtrim(BASE_URL, '/') . '/members/prayer-wall?error=post');
        }
    }
}
