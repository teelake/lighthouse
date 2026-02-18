<?php
namespace App\Controllers\Admin;

use App\Models\Media;

class MediaController extends BaseController
{
    public function index() { $this->requireEditor(); $this->render('admin/media/index', ['media' => (new Media())->findAll([], 'published_at DESC', 50), 'pageHeading' => 'Media', 'currentPage' => 'media']); }
    public function create() { $this->requireEditor(); $this->render('admin/media/form', ['item' => null, 'pageHeading' => 'Add Media', 'currentPage' => 'media']); }
    public function store() {
        $this->requireEditor();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Media())->create([
            'title' => $this->post('title'), 'slug' => $slug, 'description' => $this->post('description'),
            'media_type' => $this->post('media_type', 'video'), 'source' => $this->post('source', 'youtube'),
            'embed_url' => $this->post('embed_url'), 'is_published' => 1, 'published_at' => $this->post('published_at') ?: date('Y-m-d')
        ]);
        $this->redirectAdmin('media');
    }
    public function edit() { $this->requireEditor(); $m = (new Media())->find($this->params['id'] ?? 0); if (!$m) throw new \Exception('Not found', 404); $this->render('admin/media/form', ['item' => $m, 'pageHeading' => 'Edit Media', 'currentPage' => 'media']); }
    public function update() { $this->requireEditor(); $id = $this->params['id'] ?? 0; (new Media())->update($id, ['title' => $this->post('title'), 'description' => $this->post('description'), 'media_type' => $this->post('media_type'), 'source' => $this->post('source'), 'embed_url' => $this->post('embed_url'), 'published_at' => $this->post('published_at') ?: null]); $this->redirectAdmin('media'); }
    public function delete() { $this->requireEditor(); (new Media())->delete($this->params['id'] ?? 0); $this->redirectAdmin('media'); }
}
