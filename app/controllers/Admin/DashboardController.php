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
use App\Models\PrayerRequest;
use App\Models\PrayerWall;
use App\Models\User;

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
            'media' => (new Media())->count(),
            'job_applications' => (new JobApplication())->count(),
            'newsletter' => (new NewsletterSubscriber())->count(),
            'prayer_requests' => (new PrayerRequest())->count(),
            'prayer_wall' => (new PrayerWall())->count(),
        ];

        $upcomingEvents = (new Event())->findAll(['is_published' => 1], 'event_date ASC', 5);
        $latestNewsletter = (new NewsletterSubscriber())->findAll([], 'subscribed_at DESC', 8);
        $latestJobApps = (new JobApplication())->findAll([], 'created_at DESC', 8);
        $latestVisitors = $isAdmin ? (new FirstTimeVisitor())->findAll([], 'created_at DESC', 8) : [];

        // Enrich job applications with job title
        if (!empty($latestJobApps)) {
            $jobModel = new Job();
            foreach ($latestJobApps as &$app) {
                $app['job_title'] = '';
                if (!empty($app['job_id'])) {
                    $job = $jobModel->find($app['job_id']);
                    $app['job_title'] = $job['title'] ?? '';
                }
            }
            unset($app);
        }
        $latestPrayerRequests = $isAdmin ? (new PrayerRequest())->findAll([], 'created_at DESC', 5) : [];
        $latestPrayerPosts = $isAdmin ? (new PrayerWall())->findAll([], 'created_at DESC', 5) : [];

        $prayerUsers = [];
        if (!empty($latestPrayerPosts)) {
            $userModel = new User();
            foreach (array_unique(array_filter(array_column($latestPrayerPosts, 'user_id'))) as $uid) {
                $u = $userModel->find($uid);
                if ($u) $prayerUsers[$uid] = $u['name'] ?? $u['email'] ?? 'Unknown';
            }
        }

        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'pageHeading' => 'Dashboard',
            'currentPage' => 'dashboard',
            'stats' => $stats,
            'upcomingEvents' => $upcomingEvents,
            'latestNewsletter' => $latestNewsletter,
            'latestJobApps' => $latestJobApps,
            'latestVisitors' => $latestVisitors,
            'latestPrayerRequests' => $latestPrayerRequests,
            'latestPrayerPosts' => $latestPrayerPosts,
            'prayerUsers' => $prayerUsers,
            'isAdmin' => $isAdmin,
            'isEditor' => $isEditor,
        ]);
    }
}
