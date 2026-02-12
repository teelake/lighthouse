<?php
namespace App\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = (new Event())->findAll(['is_published' => 1], 'event_date ASC, event_time ASC');
        $this->render('events/index', ['pageTitle' => 'Events - Lighthouse Global Church', 'events' => $events]);
    }

    public function view()
    {
        $slug = $this->params['slug'] ?? '';
        $event = (new Event())->findBySlug($slug);
        if (!$event) throw new \Exception('Event not found', 404);
        $this->render('events/view', ['pageTitle' => $event['title'] . ' - Lighthouse Global Church', 'event' => $event]);
    }
}
