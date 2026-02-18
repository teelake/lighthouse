<?php
namespace App\Controllers\Admin;

use App\Models\GlimpseSlide;

class GlimpseController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $grouped = (new GlimpseSlide())->getAllGroupedByRow();
        $this->render('admin/glimpse/index', [
            'row1' => $grouped[1] ?? [],
            'row2' => $grouped[2] ?? [],
            'pageHeading' => 'Glimpse',
            'currentPage' => 'glimpse',
        ]);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/glimpse/form', ['slide' => null, 'pageHeading' => 'Add Glimpse Slide', 'currentPage' => 'glimpse']);
    }

    public function store()
    {
        $this->requireEditor();
        (new GlimpseSlide())->create([
            'image_url' => trim($this->post('image_url', '')),
            'label' => trim($this->post('label', '')),
            'row' => (int) $this->post('row', 1),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirectAdmin('glimpse');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $slide = (new GlimpseSlide())->find($id);
        if (!$slide) throw new \Exception('Not found', 404);
        $this->render('admin/glimpse/form', ['slide' => $slide, 'pageHeading' => 'Edit Glimpse Slide', 'currentPage' => 'glimpse']);
    }

    public function update()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $slide = (new GlimpseSlide())->find($id);
        if (!$slide) throw new \Exception('Not found', 404);
        (new GlimpseSlide())->update($id, [
            'image_url' => trim($this->post('image_url', '')),
            'label' => trim($this->post('label', '')),
            'row' => (int) $this->post('row', 1),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirectAdmin('glimpse');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new GlimpseSlide())->delete($id);
        $this->redirectAdmin('glimpse');
    }
}
