<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\HomepageMoment;
use App\Services\ImageUpload;

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
        $u = new ImageUpload();
        $small = $u->upload('image_small', 'moments');
        if ($small === null) {
            $err = $u->getLastError();
            if (!$err && empty($_FILES['image_small']['tmp_name'])) $err = 'Small image is required.';
            if ($err) {
                $this->render('admin/moments/form', ['moment' => null, 'error' => $err, 'pageHeading' => 'Add Moment', 'currentPage' => 'moments']);
                return;
            }
        }
        $u2 = new ImageUpload();
        $wide = $u2->upload('image_wide', 'moments');
        if ($wide === null) {
            $err = $u2->getLastError();
            if (!$err && empty($_FILES['image_wide']['tmp_name'])) $err = 'Wide image is required.';
            if ($err) {
                $this->render('admin/moments/form', ['moment' => null, 'error' => $err, 'pageHeading' => 'Add Moment', 'currentPage' => 'moments']);
                return;
            }
        }
        if (!$small || !$wide) {
            $this->render('admin/moments/form', ['moment' => null, 'error' => 'Both images are required.', 'pageHeading' => 'Add Moment', 'currentPage' => 'moments']);
            return;
        }
        (new HomepageMoment())->create([
            'image_small' => $small,
            'image_wide' => $wide,
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
        $small = $moment['image_small'] ?? '';
        $wide = $moment['image_wide'] ?? '';
        $u = new ImageUpload();
        $up = $u->upload('image_small', 'moments');
        if ($up !== null) $small = $up;
        elseif ($u->getLastError()) {
            $this->render('admin/moments/form', ['moment' => $moment, 'error' => $u->getLastError(), 'pageHeading' => 'Edit Moment', 'currentPage' => 'moments']);
            return;
        }
        $u2 = new ImageUpload();
        $up2 = $u2->upload('image_wide', 'moments');
        if ($up2 !== null) $wide = $up2;
        elseif ($u2->getLastError()) {
            $this->render('admin/moments/form', ['moment' => $moment, 'error' => $u2->getLastError(), 'pageHeading' => 'Edit Moment', 'currentPage' => 'moments']);
            return;
        }
        (new HomepageMoment())->update($id, [
            'image_small' => $small,
            'image_wide' => $wide,
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
