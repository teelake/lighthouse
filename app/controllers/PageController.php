<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;
use App\Models\Leader;
use App\Models\Setting;
use App\Models\Faq;

class PageController extends Controller
{
    public function about()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $faqs = (new Faq())->findAll([], 'sort_order ASC');
        $setting = new Setting();
        $this->render('pages/about', [
            'sections' => $sections,
            'faqs' => $faqs,
            'aboutHeroImage' => $setting->get('about_hero_image', ''),
            'aboutStoryImage' => $setting->get('about_story_image', ''),
            'pageTitle' => 'About Us - Lighthouse Global Church',
        ]);
    }

    public function leadership()
    {
        $leaders = (new Leader())->findAll(['is_published' => 1], 'sort_order ASC');
        $this->render('pages/leadership', [
            'leaders' => $leaders,
            'pageTitle' => 'Our Leadership - Lighthouse Global Church',
        ]);
    }

    public function services()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $setting = new Setting();
        $this->render('pages/services', [
            'pageTitle' => 'Our Gatherings - Lighthouse Global Church',
            'sections' => $sections,
            'serviceTimes' => [
                'sunday' => $setting->get('service_sunday', '10:00 AM'),
                'thursday' => $setting->get('service_thursday', '6:00 PM'),
            ],
        ]);
    }

    public function membership()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $this->render('pages/membership', [
            'pageTitle' => 'Membership & Training - Lighthouse Global Church',
            'sections' => $sections,
        ]);
    }

    public function contact()
    {
        $setting = new Setting();
        $mapUrl = $setting->get('map_embed_url', '');
        $this->render('pages/contact', [
            'pageTitle' => 'Contact Us - Lighthouse Global Church',
            'address' => $setting->get('site_address', '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada'),
            'phone' => $setting->get('site_phone', '902-240-2087'),
            'email' => $setting->get('site_email', 'info@thelighthouseglobal.org'),
            'mapEmbedUrl' => $mapUrl,
            'msg' => $_GET['msg'] ?? '',
        ]);
    }

    public function faq()
    {
        $faqs = (new Faq())->findAll([], 'sort_order ASC');
        $this->render('pages/faq', ['pageTitle' => 'FAQ - Lighthouse Global Church', 'faqs' => $faqs]);
    }

    public function imNew()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $this->render('pages/im-new', [
            'pageTitle' => 'I\'m New - Lighthouse Global Church',
            'sections' => $sections,
        ]);
    }
}
