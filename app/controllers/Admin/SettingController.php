<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index() { $this->requireAuth(); $this->redirect('/admin/settings/general'); }
    public function general() { $this->requireAuth(); $s = new Setting(); $this->render('admin/settings/general', ['address' => $s->get('site_address'), 'phone' => $s->get('site_phone'), 'email' => $s->get('site_email')]); }
    public function updateGeneral() { $this->requireAuth(); $s = new Setting(); $s->set('site_address', $this->post('site_address')); $s->set('site_phone', $this->post('site_phone')); $s->set('site_email', $this->post('site_email')); $this->redirect('/admin/settings/general'); }
    public function payment() { $this->requireAuth(); $s = new Setting(); $this->render('admin/settings/payment', ['paypal_email' => $s->get('paypal_email'), 'stripe_public' => $s->get('stripe_public_key'), 'stripe_secret' => $s->get('stripe_secret_key')]); }
    public function updatePayment() { $this->requireAuth(); $s = new Setting(); $s->set('paypal_email', $this->post('paypal_email')); $s->set('stripe_public_key', $this->post('stripe_public_key')); $s->set('stripe_secret_key', $this->post('stripe_secret_key')); $this->redirect('/admin/settings/payment'); }
}
