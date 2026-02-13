<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\GlimpseSlide;

class GlimpseController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $grouped = (new GlimpseSlide())->getAllGroupedByRow();
        $this->render('admin/glimpse/index', [
            'row1' => $grouped[1] ?? [],
            'row2' => $grouped[2] ?? [],
        ]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->render('admin/glimpse/form', ['slide' => null]);
    }

    public function store()
    {
        $this->requireAuth();
        (new GlimpseSlide())->create([
            'image_url' => trim($this->post('image_url', '')),
            'label' => trim($this->post('label', '')),
            'row' => (int) $this->post('row', 1),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirect('/admin/glimpse');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $slide = (new GlimpseSlide())->find($id);
        if (!$slide) throw new \Exception('Not found', 404);
        $this->render('admin/glimpse/form', ['slide' => $slide]);
    }

    public function update()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $slide = (new GlimpseSlide())->find($id);
        if (!$slide) throw new \Exception('Not found', 404);
        (new GlimpseSlide())->update($id, [
            'image_url' => trim($this->post('image_url', '')),
            'label' => trim($this->post('label', '')),
            'row' => (int) $this->post('row', 1),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirect('/admin/glimpse');
    }

    public function delete()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new GlimpseSlide())->delete($id);
        $this->redirect('/admin/glimpse');
    }
}
