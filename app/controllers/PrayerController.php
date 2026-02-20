<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\PrayerWall;

class PrayerController extends Controller
{
    public function index()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $isLoggedIn = isset($_SESSION['user_id']);
        $wallPosts = (new PrayerWall())->findAll([], 'created_at DESC', 50);
        $users = [];
        if (!empty($wallPosts)) {
            $userIds = array_unique(array_filter(array_column($wallPosts, 'user_id')));
            foreach ($userIds as $uid) {
                $u = (new \App\Models\User())->find($uid);
                $users[$uid] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }
        $this->render('prayer/index', [
            'pageTitle' => 'Prayer - Lighthouse Global Church',
            'sections' => $sections,
            'isLoggedIn' => $isLoggedIn,
            'currentUser' => $isLoggedIn ? ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name'] ?? '', 'email' => $_SESSION['user_email'] ?? ''] : null,
            'wallPosts' => $wallPosts,
            'wallUsers' => $users,
        ]);
    }

    public function submit()
    {
        // TODO: Save prayer request, send email
        $this->redirect('/prayer?submitted=1');
    }

    public function wallPost()
    {
        if (!isset($_SESSION['user_id'])) {
            $redir = urlencode('prayer');
            $loginUrl = (function_exists('admin_url') ? admin_url('login') : '/admin/login') . '?redirect=' . $redir;
            $this->redirect($loginUrl);
        }
        if (!csrf_verify()) {
            $this->redirect('/prayer?error=csrf');
        }
        $request = trim($this->post('request', ''));
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        if ($request === '') {
            $this->redirect('/prayer?error=empty');
        }
        try {
            (new PrayerWall())->create([
                'user_id' => $_SESSION['user_id'],
                'request' => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirect('/prayer?posted=1');
        } catch (\Throwable $e) {
            $this->redirect('/prayer?error=post');
        }
    }
}
