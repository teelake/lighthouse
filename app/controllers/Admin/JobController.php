<?php
namespace App\Controllers\Admin;

use App\Models\Job;

class JobController extends BaseController
{
    public function index() { $this->requireEditor(); $this->render('admin/jobs/index', ['jobs' => (new Job())->findAll([], 'sort_order ASC'), 'pageHeading' => 'Jobs', 'currentPage' => 'jobs']); }
    public function create() { $this->requireEditor(); $this->render('admin/jobs/form', ['job' => null, 'pageHeading' => 'Add Job', 'currentPage' => 'jobs']); }
    public function store() {
        $this->requireEditor();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Job())->create(['title' => $this->post('title'), 'slug' => $slug, 'type' => $this->post('type', 'full-time'), 'description' => $this->post('description'), 'is_published' => 1]);
        $this->redirectAdmin('jobs');
    }
    public function edit() { $this->requireEditor(); $j = (new Job())->find($this->params['id'] ?? 0); if (!$j) throw new \Exception('Not found', 404); $this->render('admin/jobs/form', ['job' => $j, 'pageHeading' => 'Edit Job', 'currentPage' => 'jobs']); }
    public function update() { $this->requireEditor(); $id = $this->params['id'] ?? 0; (new Job())->update($id, ['title' => $this->post('title'), 'type' => $this->post('type'), 'description' => $this->post('description')]); $this->redirectAdmin('jobs'); }
    public function delete() { $this->requireEditor(); (new Job())->delete($this->params['id'] ?? 0); $this->redirectAdmin('jobs'); }
}
