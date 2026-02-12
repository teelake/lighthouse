<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\SmallGroup;

class SmallGroupController extends Controller
{
    public function index() { $this->requireAuth(); $this->render('admin/small-groups/index', ['groups' => (new SmallGroup())->findAll([], 'sort_order ASC')]); }
    public function create() { $this->requireAuth(); $this->render('admin/small-groups/form', ['group' => null]); }
    public function store() {
        $this->requireAuth();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new SmallGroup())->create(['title' => $this->post('title'), 'slug' => $slug, 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'target_age' => $this->post('target_age'), 'is_published' => 1]);
        $this->redirect('/admin/small-groups');
    }
    public function edit() { $this->requireAuth(); $g = (new SmallGroup())->find($this->params['id'] ?? 0); if (!$g) throw new \Exception('Not found', 404); $this->render('admin/small-groups/form', ['group' => $g]); }
    public function update() { $this->requireAuth(); $id = $this->params['id'] ?? 0; (new SmallGroup())->update($id, ['title' => $this->post('title'), 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'target_age' => $this->post('target_age')]); $this->redirect('/admin/small-groups'); }
    public function delete() { $this->requireAuth(); (new SmallGroup())->delete($this->params['id'] ?? 0); $this->redirect('/admin/small-groups'); }
}
