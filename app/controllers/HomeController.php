<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\Event;
use App\Models\Media;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $sectionModel = new ContentSection();
        $eventModel = new Event();
        $mediaModel = new Media();
        $settingModel = new Setting();
        $testimonialModel = new Testimonial();

        $sections = $sectionModel->getAllKeyed();
        $events = $eventModel->findAll(['is_published' => 1], 'event_date ASC, event_time ASC', 6);
        $latestMedia = $mediaModel->findAll(['is_published' => 1], 'published_at DESC, created_at DESC', 3);
        $testimonials = $testimonialModel->findAll(['is_published' => 1], 'sort_order ASC', 3);
        $serviceTimes = [
            'sunday' => $settingModel->get('service_sunday', '10:00 AM'),
            'thursday' => $settingModel->get('service_thursday', '6:00 PM'),
        ];

        $this->render('home/index', [
            'sections' => $sections,
            'events' => $events,
            'latestMedia' => $latestMedia,
            'testimonials' => $testimonials,
            'serviceTimes' => $serviceTimes,
            'pageTitle' => 'Lighthouse Global Church - Raising Lights That Transform Nations',
        ]);
    }
}
