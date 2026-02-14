<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Leader;

class LeaderController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $leaders = (new Leader())->findAll([], 'sort_order ASC');
        $this->render('admin/leaders/index', ['leaders' => $leaders]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->render('admin/leaders/form', ['leader' => null]);
    }

    public function store()
    {
        $this->requireAuth();
        (new Leader())->create([
            'name' => trim($this->post('name', '')),
            'title' => trim($this->post('title', '')),
            'photo' => trim($this->post('photo', '')),
            'bio' => trim($this->post('bio', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirect('/admin/leaders');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $leader = (new Leader())->find($id);
        if (!$leader) throw new \Exception('Not found', 404);
        $this->render('admin/leaders/form', ['leader' => $leader]);
    }

    public function update()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $leader = (new Leader())->find($id);
        if (!$leader) throw new \Exception('Not found', 404);
        (new Leader())->update($id, [
            'name' => trim($this->post('name', '')),
            'title' => trim($this->post('title', '')),
            'photo' => trim($this->post('photo', '')),
            'bio' => trim($this->post('bio', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirect('/admin/leaders');
    }

    public function delete()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new Leader())->delete($id);
        $this->redirect('/admin/leaders');
    }
}
