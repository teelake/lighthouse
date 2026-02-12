<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $events = (new Event())->findAll([], 'event_date ASC');
        $this->render('admin/events/index', ['events' => $events]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->render('admin/events/form', ['event' => null]);
    }

    public function store()
    {
        $this->requireAuth();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($this->post('title', ''))));
        (new Event())->create([
            'title' => $this->post('title'),
            'slug' => $slug,
            'description' => $this->post('description'),
            'event_date' => $this->post('event_date') ?: null,
            'event_time' => $this->post('event_time') ?: null,
            'location' => $this->post('location'),
            'is_published' => 1,
        ]);
        $this->redirect('/admin/events');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $event = (new Event())->find($id);
        if (!$event) throw new \Exception('Not found', 404);
        $this->render('admin/events/form', ['event' => $event]);
    }

    public function update()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        $event = (new Event())->find($id);
        if (!$event) throw new \Exception('Not found', 404);
        (new Event())->update($id, [
            'title' => $this->post('title'),
            'description' => $this->post('description'),
            'event_date' => $this->post('event_date') ?: null,
            'event_time' => $this->post('event_time') ?: null,
            'location' => $this->post('location'),
        ]);
        $this->redirect('/admin/events');
    }

    public function delete()
    {
        $this->requireAuth();
        $id = $this->params['id'] ?? 0;
        (new Event())->delete($id);
        $this->redirect('/admin/events');
    }
}
