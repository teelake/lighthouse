<?php
namespace App\Controllers\Admin;

use App\Models\Testimonial;

class TestimonialController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $items = (new Testimonial())->findAll([], 'sort_order ASC');
        $this->render('admin/testimonials/index', ['testimonials' => $items, 'pageHeading' => 'Testimonials', 'currentPage' => 'testimonials']);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/testimonials/form', ['testimonial' => null, 'pageHeading' => 'Add Testimonial', 'currentPage' => 'testimonials']);
    }

    public function store()
    {
        $this->requireEditor();
        (new Testimonial())->create([
            'quote' => trim($this->post('quote', '')),
            'author_name' => trim($this->post('author_name', '')),
            'author_photo' => trim($this->post('author_photo', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirectAdmin('testimonials');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $item = (new Testimonial())->find($id);
        if (!$item) throw new \Exception('Not found', 404);
        $this->render('admin/testimonials/form', ['testimonial' => $item, 'pageHeading' => 'Edit Testimonial', 'currentPage' => 'testimonials']);
    }

    public function update()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $item = (new Testimonial())->find($id);
        if (!$item) throw new \Exception('Not found', 404);
        (new Testimonial())->update($id, [
            'quote' => trim($this->post('quote', '')),
            'author_name' => trim($this->post('author_name', '')),
            'author_photo' => trim($this->post('author_photo', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirectAdmin('testimonials');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new Testimonial())->delete($id);
        $this->redirectAdmin('testimonials');
    }
}
