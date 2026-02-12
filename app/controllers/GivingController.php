<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class GivingController extends Controller
{
    public function index()
    {
        $setting = new Setting();
        $this->render('giving/index', [
            'pageTitle' => 'Give - Lighthouse Global Church',
            'paypalEmail' => $setting->get('paypal_email', 'give@thelighthouseglobal.org'),
        ]);
    }
}
