<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\PrayerWall;

class PrayerController extends Controller
{
    private const PER_PAGE = 12;

    public function index()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $page = max(1, (int)($this->get('page', 1)));
        $offset = ($page - 1) * self::PER_PAGE;

        $result = (new PrayerWall())->findPaginated('created_at DESC', self::PER_PAGE, $offset, true);
        $posts = $result['rows'];
        $total = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $authors = [];
        if (!empty($posts)) {
            $userIds = array_unique(array_filter(array_column($posts, 'user_id')));
            foreach ($userIds as $id) {
                $u = (new \App\Models\User())->find($id);
                if ($u) $authors[$id] = $u['name'] ?? $u['email'] ?? 'A friend';
            }
        }

        $this->render('prayer/index', [
            'pageTitle' => 'Prayer - Lighthouse Global Church',
            'sections' => $sections,
            'posts' => $posts,
            'authors' => $authors,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'perPage' => self::PER_PAGE,
        ]);
    }

    public function submit()
    {
        if (!csrf_verify()) {
            $this->redirect('/prayer?error=csrf');
            return;
        }
        $request = trim($this->post('request', ''));
        $request = $request === '<p><br></p>' ? '' : $request;
        if ($request === '') {
            $this->redirect('/prayer?error=empty');
            return;
        }
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        $authorName = $isAnonymous ? '' : trim($this->post('name', ''));

        $userId = $_SESSION['user_id'] ?? null;
        if ($userId === null) {
            $userId = null;
        }

        try {
            (new PrayerWall())->create([
                'user_id' => $userId,
                'author_name' => $authorName ?: null,
                'request' => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirect('/prayer?submitted=1');
        } catch (\Throwable $e) {
            $this->redirect('/prayer?error=post');
        }
    }
}
