<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\Event;
use App\Models\GlimpseSlide;
use App\Models\HomepageMoment;
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
        $glimpseModel = new GlimpseSlide();
        $momentsModel = new HomepageMoment();

        $sections = $sectionModel->getAllKeyed();
        $events = $eventModel->findAll(['is_published' => 1], 'event_date ASC, event_time ASC', 6);
        $upcomingEvents = $eventModel->findUpcoming(3);
        $latestMedia = $mediaModel->findAll(['is_published' => 1], 'published_at DESC, created_at DESC', 3);
        $testimonials = $testimonialModel->findAll(['is_published' => 1], 'sort_order ASC', 12);
        $glimpseGrouped = $glimpseModel->getAllGroupedByRow();
        $moments = $momentsModel->findAll([], 'sort_order ASC');
        $serviceTimes = [
            'sunday' => $settingModel->get('service_sunday', '10:00 AM'),
            'thursday' => $settingModel->get('service_thursday', '6:00 PM'),
        ];
        $mapEmbedUrl = $settingModel->get('map_embed_url', '');
        $heroBackgroundImage = $settingModel->get('hero_background_image', '');
        $prayerWallImage = $settingModel->get('prayer_wall_image', '');
        $newsletterDeviceImage = $settingModel->get('newsletter_device_image', '');

        $this->render('home/index', [
            'sections' => $sections,
            'events' => $events,
            'upcomingEvents' => $upcomingEvents,
            'latestMedia' => $latestMedia,
            'testimonials' => $testimonials,
            'glimpseRow1' => $glimpseGrouped[1] ?? [],
            'glimpseRow2' => $glimpseGrouped[2] ?? [],
            'moments' => $moments,
            'serviceTimes' => $serviceTimes,
            'mapEmbedUrl' => $mapEmbedUrl,
            'heroBackgroundImage' => $heroBackgroundImage,
            'prayerWallImage' => $prayerWallImage,
            'newsletterDeviceImage' => $newsletterDeviceImage,
            'pageTitle' => 'Lighthouse Global Church - Raising Lights That Transform Nations',
        ]);
    }
}
