<?php
namespace App\Controllers\Admin;

use App\Models\PrayerRequest;
use App\Models\PrayerWall;
use App\Models\User;

class PrayerWallController extends BaseController
{
    private const PER_PAGE = 15;
    private const MAX_TITLE_LENGTH = 100;
    private const MAX_BODY_WORDS = 500;

    public function index()
    {
        $this->requireLogin();
        $role = $_SESSION['user_role'] ?? '';

        if ($role === 'member') {
            $this->showMemberView();
        } else {
            $this->requireEditor();
            $this->showManagementView();
        }
    }

    // ── Member wall view ────────────────────────────────────────────────────
    private function showMemberView(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;
        $result = (new PrayerWall())->findPaginated('created_at DESC', self::PER_PAGE, $offset, true);
        $posts  = $result['rows'];
        $total  = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
        $users = [];
        foreach ($userIds as $id) {
            $u = (new User())->find($id);
            if ($u) $users[$id] = $u['name'] ?? $u['email'] ?? 'Member';
        }

        $posted  = isset($_GET['posted']);
        $updated = isset($_GET['updated']);
        $error   = $_GET['error'] ?? null;

        $this->render('admin/prayer-wall/member', [
            'pageTitle'     => 'Prayer Wall',
            'pageHeading'   => 'Prayer Wall',
            'currentPage'   => 'prayer-wall',
            'posts'         => $posts,
            'users'         => $users,
            'posted'        => $posted,
            'updated'       => $updated,
            'error'         => $error,
            'currentUserId' => (int)($_SESSION['user_id'] ?? 0),
            'page'          => $page,
            'totalPages'    => $totalPages,
            'total'         => $total,
            'perPage'       => self::PER_PAGE,
        ]);
    }

    // ── Member: post to prayer wall ─────────────────────────────────────────
    public function postWall()
    {
        $this->requireLogin();
        if (!csrf_verify()) $this->redirectAdmin('prayer-wall?error=csrf');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirectAdmin('prayer-wall');

        $title       = mb_substr(trim($this->post('title', '')), 0, self::MAX_TITLE_LENGTH);
        $request     = trim($this->post('request', ''));
        $isAnonymous = (int) $this->post('is_anonymous', 0);

        if ($title === '') {
            $this->redirectAdmin('prayer-wall?error=empty_title');
            return;
        }
        if ($request === '' || $request === '<p><br></p>') {
            $this->redirectAdmin('prayer-wall?error=empty');
            return;
        }

        try {
            (new PrayerWall())->create([
                'title'        => $title,
                'user_id'      => (int)($_SESSION['user_id'] ?? 0),
                'request'      => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirectAdmin('prayer-wall?posted=1');
        } catch (\Throwable $e) {
            error_log('PrayerWall post error: ' . $e->getMessage());
            $this->redirectAdmin('prayer-wall?error=post');
        }
    }

    // ── Admin/editor management view ────────────────────────────────────────
    private function showManagementView(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;
        $showArchived = isset($_GET['archived']);
        $result = (new PrayerWall())->findPaginated('created_at DESC', self::PER_PAGE, $offset, $showArchived ? 'only' : true);
        $posts  = $result['rows'];
        $total  = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $requests = (new PrayerRequest())->findAll([], 'created_at DESC', 50);
        $users = [];
        if (!empty($posts)) {
            $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
            foreach ($userIds as $id) {
                $u = (new User())->find($id);
                if ($u) $users[$id] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }

        $this->render('admin/prayer-wall/index', [
            'pageTitle'    => 'Prayer Wall',
            'pageHeading'  => 'Prayer Wall',
            'currentPage'  => 'prayer-wall',
            'requests'     => $requests,
            'posts'        => $posts,
            'users'        => $users,
            'showArchived' => $showArchived,
            'page'         => $page,
            'totalPages'   => $totalPages,
            'total'        => $total,
            'perPage'      => self::PER_PAGE,
        ]);
    }

    public function viewRequest()
    {
        $this->requireEditor();
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $request = (new PrayerRequest())->find($id);
        if (!$request) $this->redirectAdmin('prayer-wall');
        $this->render('admin/prayer-wall/view-request', [
            'pageTitle'  => 'Prayer Request',
            'pageHeading'=> 'Prayer Request',
            'currentPage'=> 'prayer-wall',
            'request'    => $request,
            'isAdmin'    => ($_SESSION['user_role'] ?? '') === 'admin',
        ]);
    }

    public function archivePost()
    {
        $this->requireEditor();
        if (!csrf_verify()) return $this->redirectAdmin('prayer-wall');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');
        (new PrayerWall())->update($id, ['is_archived' => 1, 'archived_at' => date('Y-m-d H:i:s')]);
        $this->redirectAdmin('prayer-wall');
    }

    public function unarchivePost()
    {
        $this->requireEditor();
        if (!csrf_verify()) return $this->redirectAdmin('prayer-wall');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');
        (new PrayerWall())->update($id, ['is_archived' => 0, 'archived_at' => null]);
        $this->redirectAdmin('prayer-wall');
    }

    public function viewPost()
    {
        $this->requireLogin();
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');

        $role   = $_SESSION['user_role'] ?? '';
        $userId = (int)($_SESSION['user_id'] ?? 0);

        // Members can only view their own posts
        if ($role === 'member' && (int)($post['user_id'] ?? 0) !== $userId) {
            $this->redirectAdmin('prayer-wall');
            return;
        }

        $author = 'Anonymous';
        if (empty($post['is_anonymous'])) {
            if (trim($post['author_name'] ?? '')) {
                $author = $post['author_name'];
            } elseif (!empty($post['user_id'])) {
                $u = (new User())->find($post['user_id']);
                $author = $u['name'] ?? $u['email'] ?? 'Unknown';
            } else {
                $author = 'A friend';
            }
        }

        $isAdmin  = $role === 'admin';
        $canEdit  = $role === 'member' ? ((int)($post['user_id'] ?? 0) === $userId) : in_array($role, ['editor', 'admin']);
        $canDelete= $isAdmin || ($role === 'member' && (int)($post['user_id'] ?? 0) === $userId);

        $this->render('admin/prayer-wall/view-post', [
            'pageTitle'   => 'Prayer Wall Post',
            'pageHeading' => 'Prayer Wall Post',
            'currentPage' => 'prayer-wall',
            'post'        => $post,
            'author'      => $author,
            'isAdmin'     => $isAdmin,
            'canEdit'     => $canEdit,
            'canDelete'   => $canDelete,
        ]);
    }

    public function editPost()
    {
        $this->requireLogin();
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');

        $role   = $_SESSION['user_role'] ?? '';
        $userId = (int)($_SESSION['user_id'] ?? 0);
        // Members may only edit their own
        if ($role === 'member' && (int)($post['user_id'] ?? 0) !== $userId) {
            $this->redirectAdmin('prayer-wall');
            return;
        }

        $this->render('admin/prayer-wall/edit-post', [
            'pageTitle'   => 'Edit Prayer',
            'pageHeading' => 'Edit Prayer',
            'currentPage' => 'prayer-wall',
            'post'        => $post,
        ]);
    }

    public function updatePost()
    {
        $this->requireLogin();
        if (!csrf_verify()) $this->redirectAdmin('prayer-wall?error=csrf');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');

        $role   = $_SESSION['user_role'] ?? '';
        $userId = (int)($_SESSION['user_id'] ?? 0);
        if ($role === 'member' && (int)($post['user_id'] ?? 0) !== $userId) {
            $this->redirectAdmin('prayer-wall');
            return;
        }

        $title       = mb_substr(trim($this->post('title', '')), 0, self::MAX_TITLE_LENGTH);
        $request     = trim($this->post('request', ''));
        $isAnonymous = (int) $this->post('is_anonymous', 0);

        if ($title === '') {
            $this->redirectAdmin('prayer-wall/posts/' . $id . '/edit?error=empty_title');
            return;
        }
        if ($request === '' || $request === '<p><br></p>') {
            $this->redirectAdmin('prayer-wall/posts/' . $id . '/edit?error=empty');
            return;
        }

        (new PrayerWall())->update($id, [
            'title'        => $title,
            'request'      => $request,
            'is_anonymous' => $isAnonymous,
        ]);
        $this->redirectAdmin('prayer-wall?updated=1');
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
        $this->requireLogin();
        if (!csrf_verify()) return $this->redirectAdmin('prayer-wall');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('prayer-wall');
        $post = (new PrayerWall())->find($id);
        if (!$post) $this->redirectAdmin('prayer-wall');

        $role   = $_SESSION['user_role'] ?? '';
        $userId = (int)($_SESSION['user_id'] ?? 0);
        // Members may only delete their own; editors/admins can delete any
        if ($role === 'member' && (int)($post['user_id'] ?? 0) !== $userId) {
            $this->redirectAdmin('prayer-wall');
            return;
        }
        if (!in_array($role, ['admin', 'editor', 'member'])) {
            $this->redirectAdmin('prayer-wall');
            return;
        }

        (new PrayerWall())->delete($id);
        $this->redirectAdmin('prayer-wall');
    }
}
