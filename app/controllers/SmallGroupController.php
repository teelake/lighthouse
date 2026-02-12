<?php
namespace App\Controllers;

use App\Models\SmallGroup;

class SmallGroupController extends Controller
{
    public function index()
    {
        $groups = (new SmallGroup())->findAll(['is_published' => 1], 'sort_order ASC');
        $this->render('small-groups/index', ['pageTitle' => 'Small Groups - Lighthouse Global Church', 'groups' => $groups]);
    }

    public function view()
    {
        $slug = $this->params['slug'] ?? '';
        $group = (new SmallGroup())->findBySlug($slug);
        if (!$group) throw new \Exception('Small group not found', 404);
        $this->render('small-groups/view', ['pageTitle' => $group['title'] . ' - Lighthouse Global Church', 'group' => $group]);
    }
}
