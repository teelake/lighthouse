<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Ministry;

class MinistryController extends Controller
{
    public function index() { $this->requireAuth(); $this->render('admin/ministries/index', ['ministries' => (new Ministry())->findAll([], 'sort_order ASC')]); }
    public function create() { $this->requireAuth(); $this->render('admin/ministries/form', ['ministry' => null]); }
    public function store() {
        $this->requireAuth();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Ministry())->create(['title' => $this->post('title'), 'slug' => $slug, 'tagline' => $this->post('tagline'), 'description' => $this->post('description'), 'is_published' => 1]);
        $this->redirect('/admin/ministries');
    }
    public function edit() { $this->requireAuth(); $m = (new Ministry())->find($this->params['id'] ?? 0); if (!$m) throw new \Exception('Not found', 404); $this->render('admin/ministries/form', ['ministry' => $m]); }
    public function update() {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new Ministry())->update($id, ['title' => $this->post('title'), 'tagline' => $this->post('tagline'), 'description' => $this->post('description')]);
        $this->redirect('/admin/ministries');
    }
    public function delete() { $this->requireAuth(); (new Ministry())->delete($this->params['id'] ?? 0); $this->redirect('/admin/ministries'); }
}
