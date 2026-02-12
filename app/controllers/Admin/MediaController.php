<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Media;

class MediaController extends Controller
{
    public function index() { $this->requireAuth(); $this->render('admin/media/index', ['media' => (new Media())->findAll([], 'published_at DESC', 50)]); }
    public function create() { $this->requireAuth(); $this->render('admin/media/form', ['item' => null]); }
    public function store() {
        $this->requireAuth();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Media())->create([
            'title' => $this->post('title'), 'slug' => $slug, 'description' => $this->post('description'),
            'media_type' => $this->post('media_type', 'video'), 'source' => $this->post('source', 'youtube'),
            'embed_url' => $this->post('embed_url'), 'is_published' => 1, 'published_at' => $this->post('published_at') ?: date('Y-m-d')
        ]);
        $this->redirect('/admin/media');
    }
    public function edit() { $this->requireAuth(); $m = (new Media())->find($this->params['id'] ?? 0); if (!$m) throw new \Exception('Not found', 404); $this->render('admin/media/form', ['item' => $m]); }
    public function update() { $this->requireAuth(); $id = $this->params['id'] ?? 0; (new Media())->update($id, ['title' => $this->post('title'), 'description' => $this->post('description'), 'media_type' => $this->post('media_type'), 'source' => $this->post('source'), 'embed_url' => $this->post('embed_url'), 'published_at' => $this->post('published_at') ?: null]); $this->redirect('/admin/media'); }
    public function delete() { $this->requireAuth(); (new Media())->delete($this->params['id'] ?? 0); $this->redirect('/admin/media'); }
}
