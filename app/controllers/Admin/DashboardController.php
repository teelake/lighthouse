<?php
namespace App\Controllers\Admin;

use App\Models\Event;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->requireAuth();
        $events = (new Event())->findAll([], 'event_date ASC', 5);
        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'pageHeading' => 'Dashboard',
            'currentPage' => 'dashboard',
            'events' => $events,
        ]);
    }
}
