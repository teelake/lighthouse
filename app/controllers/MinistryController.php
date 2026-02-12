<?php
namespace App\Controllers;

use App\Models\Ministry;

class MinistryController extends Controller
{
    public function index()
    {
        $ministries = (new Ministry())->findAll(['is_published' => 1], 'sort_order ASC');
        $this->render('ministries/index', ['pageTitle' => 'Our Ministries - Lighthouse Global Church', 'ministries' => $ministries]);
    }

    public function view()
    {
        $slug = $this->params['slug'] ?? '';
        $ministry = (new Ministry())->findBySlug($slug);
        if (!$ministry) throw new \Exception('Ministry not found', 404);
        $this->render('ministries/view', ['pageTitle' => $ministry['title'] . ' - Lighthouse Global Church', 'ministry' => $ministry]);
    }
}
