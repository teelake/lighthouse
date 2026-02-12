<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Event;
use App\Models\NewsletterSubscriber;
use App\Models\PrayerRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $events = (new Event())->findAll([], 'event_date ASC', 5);
        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'events' => $events,
        ]);
    }
}
