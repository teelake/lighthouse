<?php
namespace App\Controllers\Admin;

use App\Models\Leader;
use App\Services\ImageUpload;

class LeaderController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $leaders = (new Leader())->findAll([], 'sort_order ASC');
        $this->render('admin/leaders/index', ['leaders' => $leaders, 'pageHeading' => 'Leadership', 'currentPage' => 'leaders']);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/leaders/form', ['leader' => null, 'pageHeading' => 'Add Leader', 'currentPage' => 'leaders']);
    }

    public function store()
    {
        $this->requireEditor();
        $photo = '';
        $u = new ImageUpload();
        $up = $u->upload('photo', 'leaders');
        if ($up !== null) $photo = $up;
        elseif ($u->getLastError()) {
            $this->render('admin/leaders/form', ['leader' => null, 'error' => $u->getLastError(), 'pageHeading' => 'Add Leader', 'currentPage' => 'leaders']);
            return;
        }
        (new Leader())->create([
            'name' => trim($this->post('name', '')),
            'title' => trim($this->post('title', '')),
            'photo' => $photo,
            'bio' => trim($this->post('bio', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirectAdmin('leaders');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $leader = (new Leader())->find($id);
        if (!$leader) throw new \Exception('Not found', 404);
        $this->render('admin/leaders/form', ['leader' => $leader, 'pageHeading' => 'Edit Leader', 'currentPage' => 'leaders']);
    }

    public function update()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $leader = (new Leader())->find($id);
        if (!$leader) throw new \Exception('Not found', 404);
        $photo = $leader['photo'] ?? '';
        $u = new ImageUpload();
        $up = $u->upload('photo', 'leaders');
        if ($up !== null) $photo = $up;
        elseif ($u->getLastError()) {
            $this->render('admin/leaders/form', ['leader' => $leader, 'error' => $u->getLastError(), 'pageHeading' => 'Edit Leader', 'currentPage' => 'leaders']);
            return;
        }
        (new Leader())->update($id, [
            'name' => trim($this->post('name', '')),
            'title' => trim($this->post('title', '')),
            'photo' => $photo,
            'bio' => trim($this->post('bio', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirectAdmin('leaders');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new Leader())->delete($id);
        $this->redirectAdmin('leaders');
    }
}
