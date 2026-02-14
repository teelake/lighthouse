<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;
use App\Models\ContentSection;

class GivingController extends Controller
{
    public function index()
    {
        $setting = new Setting();
        $sections = (new ContentSection())->getAllKeyed();
        $this->render('giving/index', [
            'pageTitle' => 'Give - Lighthouse Global Church',
            'paypalEmail' => $setting->get('paypal_email', 'give@thelighthouseglobal.org'),
            'paypalUrl' => $setting->get('paypal_donate_url', ''),
            'sections' => $sections,
        ]);
    }
}
