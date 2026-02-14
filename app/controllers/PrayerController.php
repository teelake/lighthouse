<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContentSection;

class PrayerController extends Controller
{
    public function index()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $this->render('prayer/index', [
            'pageTitle' => 'Prayer - Lighthouse Global Church',
            'sections' => $sections,
        ]);
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
