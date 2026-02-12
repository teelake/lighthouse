<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ContentSection;

class SectionController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $sections = (new ContentSection())->findAll([], 'sort_order ASC');
        $this->render('admin/sections/index', ['sections' => $sections]);
    }

    public function edit()
    {
        $this->requireAuth();
        $key = $this->params['key'] ?? '';
        $section = (new ContentSection())->getByKey($key);
        if (!$section) throw new \Exception('Section not found', 404);
        $this->render('admin/sections/edit', ['section' => $section]);
    }

    public function update()
    {
        $this->requireAuth();
        $key = $this->params['key'] ?? '';
        $section = (new ContentSection())->getByKey($key);
        if (!$section) throw new \Exception('Section not found', 404);
        $content = $this->post('content', '');
        (new ContentSection())->update($section['id'], ['content' => $content]);
        $this->redirect('/admin/sections');
    }
}
