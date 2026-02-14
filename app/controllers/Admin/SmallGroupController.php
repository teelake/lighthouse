<?php
namespace App\Controllers\Admin;

use App\Models\SmallGroup;

class SmallGroupController extends BaseController
{
    public function index() { $this->requireEditor(); $this->render('admin/small-groups/index', ['groups' => (new SmallGroup())->findAll([], 'sort_order ASC')]); }
    public function create() { $this->requireEditor(); $this->render('admin/small-groups/form', ['group' => null]); }
    public function store() {
        $this->requireEditor();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new SmallGroup())->create(['title' => $this->post('title'), 'slug' => $slug, 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'target_age' => $this->post('target_age'), 'is_published' => 1]);
        $this->redirectAdmin('small-groups');
    }
    public function edit() { $this->requireEditor(); $g = (new SmallGroup())->find($this->params['id'] ?? 0); if (!$g) throw new \Exception('Not found', 404); $this->render('admin/small-groups/form', ['group' => $g]); }
    public function update() { $this->requireEditor(); $id = $this->params['id'] ?? 0; (new SmallGroup())->update($id, ['title' => $this->post('title'), 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'target_age' => $this->post('target_age')]); $this->redirectAdmin('small-groups'); }
    public function delete() { $this->requireEditor(); (new SmallGroup())->delete($this->params['id'] ?? 0); $this->redirectAdmin('small-groups'); }
}
