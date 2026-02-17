<?php
namespace App\Controllers\Admin;

use App\Models\Event;
use App\Models\Ministry;
use App\Models\Leader;
use App\Models\Testimonial;
use App\Models\Media;
use App\Models\Job;
use App\Models\SmallGroup;
use App\Models\GlimpseSlide;
use App\Models\HomepageMoment;
use App\Models\JobApplication;
use App\Models\NewsletterSubscriber;
use App\Models\FirstTimeVisitor;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->requireAuth();
        $isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
        $isEditor = in_array($_SESSION['user_role'] ?? '', ['editor', 'admin']);

        $stats = [
            'events' => (new Event())->count(),
            'ministries' => (new Ministry())->count(),
            'leaders' => (new Leader())->count(),
            'testimonials' => (new Testimonial())->count(),
            'media' => (new Media())->count(),
            'jobs' => (new Job())->count(),
            'job_applications' => (new JobApplication())->count(),
            'newsletter' => (new NewsletterSubscriber())->count(),
        ];

        $upcomingEvents = (new Event())->findAll(['is_published' => 1], 'event_date ASC', 5);
        $latestNewsletter = (new NewsletterSubscriber())->findAll([], 'subscribed_at DESC', 5);
        $latestJobApps = (new JobApplication())->findAll([], 'created_at DESC', 5);
        $latestVisitors = $isAdmin ? (new FirstTimeVisitor())->findAll([], 'created_at DESC', 5) : [];

        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'pageHeading' => 'Dashboard',
            'currentPage' => 'dashboard',
            'stats' => $stats,
            'upcomingEvents' => $upcomingEvents,
            'latestNewsletter' => $latestNewsletter,
            'latestJobApps' => $latestJobApps,
            'latestVisitors' => $latestVisitors,
            'isAdmin' => $isAdmin,
            'isEditor' => $isEditor,
        ]);
    }
}
