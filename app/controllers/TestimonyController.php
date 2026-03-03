<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\Testimony;

class TestimonyController extends Controller
{
    private const PER_PAGE = 12;

    public function index()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $page = max(1, (int)($this->get('page', 1)));
        $offset = ($page - 1) * self::PER_PAGE;

        $result = (new Testimony())->findPaginated('created_at DESC', self::PER_PAGE, $offset, true);
        $items = $result['rows'];
        $total = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        $this->render('testimonies/index', [
            'pageTitle' => 'Testimonies - Lighthouse Global Church',
            'sections' => $sections,
            'items' => $items,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'perPage' => self::PER_PAGE,
        ]);
    }

    public function submit()
    {
        if (!csrf_verify()) {
            $this->redirect('/testimonies?error=csrf');
            return;
        }
        $content = trim($this->post('content', ''));
        $content = $content === '<p><br></p>' ? '' : $content;
        if ($content === '') {
            $this->redirect('/testimonies?error=empty');
            return;
        }
        $isAnonymous = (int) $this->post('is_anonymous', 0);
        $authorName = $isAnonymous ? '' : trim($this->post('name', ''));

        try {
            (new Testimony())->create([
                'content' => $content,
                'author_name' => $authorName ?: null,
                'is_anonymous' => $isAnonymous,
            ]);
            $this->redirect('/testimonies?submitted=1');
        } catch (\Throwable $e) {
            $this->redirect('/testimonies?error=post');
        }
    }
}
