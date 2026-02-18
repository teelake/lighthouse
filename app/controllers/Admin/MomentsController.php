<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\HomepageMoment;

class MomentsController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $moments = (new HomepageMoment())->findAll([], 'sort_order ASC');
        $this->render('admin/moments/index', ['moments' => $moments, 'pageHeading' => 'Moments', 'currentPage' => 'moments']);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/moments/form', ['moment' => null, 'pageHeading' => 'Add Moment', 'currentPage' => 'moments']);
    }

    public function store()
    {
        $this->requireEditor();
        (new HomepageMoment())->create([
            'image_small' => trim($this->post('image_small', '')),
            'image_wide' => trim($this->post('image_wide', '')),
            'alt_small' => trim($this->post('alt_small', '')),
            'alt_wide' => trim($this->post('alt_wide', '')),
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirectAdmin('moments');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $moment = (new HomepageMoment())->find($id);
        if (!$moment) throw new \Exception('Not found', 404);
        $this->render('admin/moments/form', ['moment' => $moment, 'pageHeading' => 'Edit Moment', 'currentPage' => 'moments']);
    }

    public function update()
    {
        $this->requireEditor();
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
        $this->redirectAdmin('moments');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new HomepageMoment())->delete($id);
        $this->redirectAdmin('moments');
    }
}
