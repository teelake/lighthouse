<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $items = (new Testimonial())->findAll([], 'sort_order ASC');
        $this->render('admin/testimonials/index', ['testimonials' => $items]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->render('admin/testimonials/form', ['testimonial' => null]);
    }

    public function store()
    {
        $this->requireAuth();
        (new Testimonial())->create([
            'quote' => trim($this->post('quote', '')),
            'author_name' => trim($this->post('author_name', '')),
            'author_photo' => trim($this->post('author_photo', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
            'is_published' => $this->post('is_published') ? 1 : 0,
        ]);
        $this->redirect('/admin/testimonials');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $item = (new Testimonial())->find($id);
        if (!$item) throw new \Exception('Not found', 404);
        $this->render('admin/testimonials/form', ['testimonial' => $item]);
    }

    public function update()
    {
        $this->requireAuth();
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
        $this->redirect('/admin/testimonials');
    }

    public function delete()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new Testimonial())->delete($id);
        $this->redirect('/admin/testimonials');
    }
}
