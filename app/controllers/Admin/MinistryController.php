<?php
namespace App\Controllers\Admin;

use App\Models\Ministry;

class MinistryController extends BaseController
{
    public function index() { $this->requireEditor(); $this->render('admin/ministries/index', ['ministries' => (new Ministry())->findAll([], 'sort_order ASC')]); }
    public function create() { $this->requireEditor(); $this->render('admin/ministries/form', ['ministry' => null]); }
    public function store() {
        $this->requireEditor();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Ministry())->create(['title' => $this->post('title'), 'slug' => $slug, 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'is_published' => 1]);
        $this->redirectAdmin('ministries');
    }
    public function edit() { $this->requireEditor(); $m = (new Ministry())->find($this->params['id'] ?? 0); if (!$m) throw new \Exception('Not found', 404); $this->render('admin/ministries/form', ['ministry' => $m]); }
    public function update() {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new Ministry())->update($id, ['title' => $this->post('title'), 'tagline' => $this->post('tagline'), 'description' => $this->post('description')]);
        $this->redirectAdmin('ministries');
    }
    public function delete() { $this->requireEditor(); (new Ministry())->delete($this->params['id'] ?? 0); $this->redirectAdmin('ministries'); }
}
