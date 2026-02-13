<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\HomepageMoment;

class MomentsController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $moments = (new HomepageMoment())->findAll([], 'sort_order ASC');
        $this->render('admin/moments/index', ['moments' => $moments]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->render('admin/moments/form', ['moment' => null]);
    }

    public function store()
    {
        $this->requireAuth();
        (new HomepageMoment())->create([
            'image_small' => trim($this->post('image_small', '')),
            'image_wide' => trim($this->post('image_wide', '')),
            'alt_small' => trim($this->post('alt_small', '')),
            'alt_wide' => trim($this->post('alt_wide', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirect('/admin/moments');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $moment = (new HomepageMoment())->find($id);
        if (!$moment) throw new \Exception('Not found', 404);
        $this->render('admin/moments/form', ['moment' => $moment]);
    }

    public function update()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $moment = (new HomepageMoment())->find($id);
        if (!$moment) throw new \Exception('Not found', 404);
        (new HomepageMoment())->update($id, [
            'image_small' => trim($this->post('image_small', '')),
            'image_wide' => trim($this->post('image_wide', '')),
            'alt_small' => trim($this->post('alt_small', '')),
            'alt_wide' => trim($this->post('alt_wide', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirect('/admin/moments');
    }

    public function delete()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new HomepageMoment())->delete($id);
        $this->redirect('/admin/moments');
    }
}
