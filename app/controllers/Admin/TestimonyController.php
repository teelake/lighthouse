<?php
namespace App\Controllers\Admin;

use App\Models\Testimony;

class TestimonyController extends BaseController
{
    private const MAX_WORDS = 300;
    public function index()
    {
        $this->requireEditor();
        $this->showManagementView();
    }

    private const PER_PAGE = 15;

    private function showManagementView(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;
        $showArchived = isset($_GET['archived']);
        $search = trim($_GET['search'] ?? '');
        $filters = $search !== '' ? ['search' => $search] : [];
        $result = (new Testimony())->findPaginatedFiltered($filters, 'created_at DESC', self::PER_PAGE, $offset, $showArchived ? 'only' : true);
        $items = $result['rows'];
        $total = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $this->render('admin/testimonies/index', [
            'pageTitle' => 'Online Testimonies',
            'pageHeading' => 'Online Testimonies',
            'currentPage' => 'testimonies',
            'items' => $items,
            'showArchived' => $showArchived,
            'search' => $search,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'perPage' => self::PER_PAGE,
        ]);
    }

    public function view()
    {
        $this->requireEditor();
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        $item = (new Testimony())->find($id);
        if (!$item) $this->redirectAdmin('testimonies');
        $author = ($item['is_anonymous'] ?? 0) ? 'Anonymous' : (trim($item['author_name'] ?? '') ?: 'A friend');
        $this->render('admin/testimonies/view', [
            'pageTitle' => 'View Testimony',
            'pageHeading' => 'View Testimony',
            'currentPage' => 'testimonies',
            'item' => $item,
            'author' => $author,
            'isAdmin' => ($_SESSION['user_role'] ?? '') === 'admin',
        ]);
    }

    public function edit()
    {
        $this->requireEditor();
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        $item = (new Testimony())->find($id);
        if (!$item) $this->redirectAdmin('testimonies');
        $this->render('admin/testimonies/edit', [
            'pageTitle' => 'Edit Testimony',
            'pageHeading' => 'Edit Testimony',
            'currentPage' => 'testimonies',
            'item' => $item,
            'maxWords' => self::MAX_WORDS,
        ]);
    }

    public function update()
    {
        $this->requireEditor();
        if (!csrf_verify()) $this->redirectAdmin('testimonies?error=csrf');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        $item = (new Testimony())->find($id);
        if (!$item) $this->redirectAdmin('testimonies');
        $content = trim($this->post('content', ''));
        $content = $content === '<p><br></p>' ? '' : $content;
        if ($content === '') {
            $this->redirectAdmin('testimonies/' . $id . '/edit?error=empty');
            return;
        }
        if (str_word_count(strip_tags($content)) > self::MAX_WORDS) {
            $this->redirectAdmin('testimonies/' . $id . '/edit?error=maxwords');
            return;
        }
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        $authorName = $isAnonymous ? '' : trim($this->post('name', ''));
        (new Testimony())->update($id, [
            'content' => $content,
            'author_name' => $authorName ?: null,
            'is_anonymous' => $isAnonymous,
        ]);
        $this->redirectAdmin('testimonies?updated=1');
    }

    public function archive()
    {
        $this->requireEditor();
        if (!csrf_verify()) return $this->redirectAdmin('testimonies');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        $item = (new Testimony())->find($id);
        if (!$item) $this->redirectAdmin('testimonies');
        (new Testimony())->update($id, ['is_archived' => 1, 'archived_at' => date('Y-m-d H:i:s')]);
        $this->redirectAdmin('testimonies');
    }

    public function unarchive()
    {
        $this->requireEditor();
        if (!csrf_verify()) return $this->redirectAdmin('testimonies');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        $item = (new Testimony())->find($id);
        if (!$item) $this->redirectAdmin('testimonies');
        (new Testimony())->update($id, ['is_archived' => 0, 'archived_at' => null]);
        $this->redirectAdmin('testimonies');
    }

    public function delete()
    {
        $this->requireAdmin();
        if (!csrf_verify()) return $this->redirectAdmin('testimonies');
        $id = (int)($this->params['id'] ?? 0);
        if (!$id) $this->redirectAdmin('testimonies');
        (new Testimony())->delete($id);
        $this->redirectAdmin('testimonies');
    }
}
