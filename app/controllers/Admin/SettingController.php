<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\Setting;

class SettingController extends BaseController
{
    public function index() { $this->requireAdmin(); $this->redirectAdmin('settings/general'); }
    public function general() { $this->requireAdmin(); $s = new Setting(); $this->render('admin/settings/general', ['address' => $s->get('site_address'), 'phone' => $s->get('site_phone'), 'email' => $s->get('site_email')]); }
    public function updateGeneral() { $this->requireAdmin(); $s = new Setting(); $s->set('site_address', $this->post('site_address')); $s->set('site_phone', $this->post('site_phone')); $s->set('site_email', $this->post('site_email')); $this->redirectAdmin('settings/general'); }
    public function payment() { $this->requireAdmin(); $s = new Setting(); $this->render('admin/settings/payment', ['paypal_email' => $s->get('paypal_email'), 'stripe_public' => $s->get('stripe_public_key'), 'stripe_secret' => $s->get('stripe_secret_key')]); }
    public function updatePayment() { $this->requireAdmin(); $s = new Setting(); $s->set('paypal_email', $this->post('paypal_email')); $s->set('stripe_public_key', $this->post('stripe_public_key')); $s->set('stripe_secret_key', $this->post('stripe_secret_key')); $this->redirectAdmin('settings/payment'); }

    public function homepage()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/homepage', [
            'map_embed_url' => $s->get('map_embed_url', ''),
            'prayer_wall_image' => $s->get('prayer_wall_image', ''),
            'newsletter_device_image' => $s->get('newsletter_device_image', ''),
            'service_sunday' => $s->get('service_sunday', '10:00 AM'),
            'service_thursday' => $s->get('service_thursday', '6:00 PM'),
        ]);
    }

    public function updateHomepage()
    {
        $this->requireAdmin();
        $s = new Setting();
        $s->set('map_embed_url', $this->post('map_embed_url', ''));
        $s->set('prayer_wall_image', $this->post('prayer_wall_image', ''));
        $s->set('newsletter_device_image', $this->post('newsletter_device_image', ''));
        $s->set('service_sunday', $this->post('service_sunday', '10:00 AM'));
        $s->set('service_thursday', $this->post('service_thursday', '6:00 PM'));
        $this->redirectAdmin('settings/homepage');
    }
}
