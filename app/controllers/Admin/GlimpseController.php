<?php
namespace App\Controllers\Admin;

use App\Models\GlimpseSlide;
use App\Services\ImageUpload;

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
        $u = new ImageUpload();
        $img = $u->upload('image_url', 'glimpse');
        if ($img === null) {
            $err = $u->getLastError();
            if (!$err && empty($_FILES['image_url']['tmp_name'])) $err = 'Image is required.';
            if ($err) {
                $this->render('admin/glimpse/form', ['slide' => null, 'error' => $err, 'pageHeading' => 'Add Glimpse Slide', 'currentPage' => 'glimpse']);
                return;
            }
        }
        if (!$img) {
            $this->render('admin/glimpse/form', ['slide' => null, 'error' => 'Image is required.', 'pageHeading' => 'Add Glimpse Slide', 'currentPage' => 'glimpse']);
            return;
        }
        (new GlimpseSlide())->create([
            'image_url' => $img,
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
        $img = $slide['image_url'] ?? '';
        $u = new ImageUpload();
        $up = $u->upload('image_url', 'glimpse');
        if ($up !== null) $img = $up;
        elseif ($u->getLastError()) {
            $this->render('admin/glimpse/form', ['slide' => $slide, 'error' => $u->getLastError(), 'pageHeading' => 'Edit Glimpse Slide', 'currentPage' => 'glimpse']);
            return;
        }
        (new GlimpseSlide())->update($id, [
            'image_url' => $img,
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
