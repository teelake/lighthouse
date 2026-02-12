<?php
namespace App\Controllers;

use App\Core\Controller;

class PrayerController extends Controller
{
    public function index()
    {
        $this->render('prayer/index', ['pageTitle' => 'Prayer - Lighthouse Global Church']);
    }

    public function submit()
    {
        // TODO: Save prayer request, send email
        $this->redirect('/prayer?submitted=1');
    }

    public function wallPost()
    {
        // TODO: Members only
        $this->redirect('/prayer');
    }
}
