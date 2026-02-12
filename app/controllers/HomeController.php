<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\Event;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $sectionModel = new ContentSection();
        $eventModel = new Event();
        $settingModel = new Setting();
        $testimonialModel = new Testimonial();

        $sections = $sectionModel->getAllKeyed();
        $events = $eventModel->findAll(['is_published' => 1], 'event_date ASC, event_time ASC', 6);
        $testimonials = $testimonialModel->findAll(['is_published' => 1], 'sort_order ASC', 3);
        $serviceTimes = [
            'sunday' => $settingModel->get('service_sunday', '10:00 AM'),
            'thursday' => $settingModel->get('service_thursday', '6:00 PM'),
        ];

        $this->render('home/index', [
            'sections' => $sections,
            'events' => $events,
            'testimonials' => $testimonials,
            'serviceTimes' => $serviceTimes,
            'pageTitle' => 'Lighthouse Global Church - Raising Lights That Transform Nations',
        ]);
    }
}
