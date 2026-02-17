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

class DashboardController extends BaseController
{
    public function index()
    {
        $this->requireAuth();

        $stats = [
            'events' => (new Event())->count(),
            'ministries' => (new Ministry())->count(),
            'leaders' => (new Leader())->count(),
            'testimonials' => (new Testimonial())->count(),
            'media' => (new Media())->count(),
            'jobs' => (new Job())->count(),
            'small_groups' => (new SmallGroup())->count(),
            'glimpse' => (new GlimpseSlide())->count(),
            'moments' => (new HomepageMoment())->count(),
            'job_applications' => (new JobApplication())->count(),
            'newsletter' => (new NewsletterSubscriber())->count(),
        ];

        $events = (new Event())->findAll(['is_published' => 1], 'event_date ASC', 5);

        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'pageHeading' => 'Dashboard',
            'currentPage' => 'dashboard',
            'stats' => $stats,
            'events' => $events,
            'isAdmin' => ($_SESSION['user_role'] ?? '') === 'admin',
        ]);
    }
}
