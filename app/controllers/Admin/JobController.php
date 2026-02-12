<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Job;

class JobController extends Controller
{
    public function index() { $this->requireAuth(); $this->render('admin/jobs/index', ['jobs' => (new Job())->findAll([], 'sort_order ASC')]); }
    public function create() { $this->requireAuth(); $this->render('admin/jobs/form', ['job' => null]); }
    public function store() {
        $this->requireAuth();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Job())->create(['title' => $this->post('title'), 'slug' => $slug, 'type' => $this->post('type', 'full-time'), 'description' => $this->post('description'), 'is_published' => 1]);
        $this->redirect('/admin/jobs');
    }
    public function edit() { $this->requireAuth(); $j = (new Job())->find($this->params['id'] ?? 0); if (!$j) throw new \Exception('Not found', 404); $this->render('admin/jobs/form', ['job' => $j]); }
    public function update() { $this->requireAuth(); $id = $this->params['id'] ?? 0; (new Job())->update($id, ['title' => $this->post('title'), 'type' => $this->post('type'), 'description' => $this->post('description')]); $this->redirect('/admin/jobs'); }
    public function delete() { $this->requireAuth(); (new Job())->delete($this->params['id'] ?? 0); $this->redirect('/admin/jobs'); }
}
