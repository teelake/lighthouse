<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\PrayerWall;
use App\Models\Setting;
use App\Services\MailService;

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
        $title   = mb_substr(trim($this->post('title', '')), 0, 100);
        $request = trim($this->post('request', ''));
        $request = $request === '<p><br></p>' ? '' : $request;
        if ($title === '') {
            $this->redirect('/prayer?error=empty_title');
            return;
        }
        if ($request === '') {
            $this->redirect('/prayer?error=empty');
            return;
        }
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        $authorName = $isAnonymous ? '' : trim($this->post('name', ''));

        $userId = $_SESSION['user_id'] ?? null;

        try {
            (new PrayerWall())->create([
                'title'        => $title,
                'user_id'      => $userId,
                'author_name'  => $authorName ?: null,
                'request'      => $request,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->notifyAdminNewPrayer($title, $request, $isAnonymous, $authorName, $userId);
            $this->redirect('/prayer?submitted=1');
        } catch (\Throwable $e) {
            $this->redirect('/prayer?error=post');
        }
    }

    public function view()
    {
        $id   = (int)($this->params['id'] ?? 0);
        if (!$id) {
            $this->redirect('/prayer');
            return;
        }

        $post = (new PrayerWall())->find($id);
        if (!$post || !empty($post['is_archived'])) {
            $this->redirect('/prayer');
            return;
        }

        $author = 'Anonymous';
        if (empty($post['is_anonymous'])) {
            if (trim($post['author_name'] ?? '')) {
                $author = $post['author_name'];
            } elseif (!empty($post['user_id'])) {
                $u = (new \App\Models\User())->find($post['user_id']);
                $author = $u['name'] ?? $u['email'] ?? 'A friend';
            } else {
                $author = 'A friend';
            }
        }

        $title = trim($post['title'] ?? '') ?: 'Prayer Request';

        $this->render('prayer/view', [
            'pageTitle'       => $title . ' — Prayer Wall | Lighthouse Global Church',
            'pageDescription' => 'Read and pray along with this prayer shared on the Lighthouse Global Church Prayer Wall.',
            'post'            => $post,
            'author'          => $author,
            'title'           => $title,
        ]);
    }

    private function notifyAdminNewPrayer(string $title, string $request, int $isAnonymous, string $authorName, ?int $userId): void
    {
        $setting = new Setting();
        $to = trim($setting->get('site_email', ''));
        if (!$to || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        $author = $isAnonymous ? 'Anonymous' : ($authorName ?: null);
        if ($author === null && $userId) {
            $u = (new \App\Models\User())->find($userId);
            $author = $u['name'] ?? $u['email'] ?? 'A church member';
        }
        $author = $author ?? 'A friend';
        $adminUrl = function_exists('admin_url') ? admin_url('prayer-wall') : (rtrim(BASE_URL ?? '', '/') . '/' . (defined('ADMIN_PATH') ? ADMIN_PATH : 'admin') . '/prayer-wall');
        $subject = 'New prayer posted on the Prayer Wall – Lighthouse Global Church';
        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: sans-serif; line-height: 1.6; color: #333;">';
        $body .= '<h2>New Prayer Posted</h2>';
        $body .= '<p><strong>Author:</strong> ' . htmlspecialchars($author) . '</p>';
        if ($title) {
            $body .= '<p><strong>Subject:</strong> ' . htmlspecialchars($title) . '</p>';
        }
        $body .= '<p><strong>Prayer:</strong></p>';
        $body .= '<div style="background: #f8f8f8; padding: 1rem; border-radius: 6px; margin: 0.5rem 0;">' . (function_exists('rich_content') ? rich_content($request) : nl2br(htmlspecialchars(strip_tags($request)))) . '</div>';
        $body .= '<p><a href="' . htmlspecialchars($adminUrl) . '" style="display: inline-block; background: #d4a017; color: #1a1a1a; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-weight: 600;">View Prayer Wall</a></p>';
        $body .= '<p style="color: #666; font-size: 0.9rem;">— Lighthouse Global Church</p>';
        $body .= '</body></html>';
        try {
            (new MailService())->send($to, 'Lighthouse Global Church', $subject, $body);
        } catch (\Throwable $e) {
            // Log but don't fail the submission
        }
    }
}
