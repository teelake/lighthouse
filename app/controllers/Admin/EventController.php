<?php
namespace App\Controllers\Admin;

use App\Models\Event;

class EventController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $events = (new Event())->findAll([], 'event_date ASC');
        $this->render('admin/events/index', ['events' => $events, 'pageHeading' => 'Events', 'currentPage' => 'events']);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/events/form', ['event' => null, 'pageHeading' => 'Add Event', 'currentPage' => 'events']);
    }

    public function store()
    {
        $this->requireEditor();
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
        $this->redirectAdmin('events');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $event = (new Event())->find($id);
        if (!$event) throw new \Exception('Not found', 404);
        $this->render('admin/events/form', ['event' => $event, 'pageHeading' => 'Edit Event', 'currentPage' => 'events']);
    }

    public function update()
    {
        $this->requireEditor();
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
        $this->redirectAdmin('events');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new Event())->delete($id);
        $this->redirectAdmin('events');
    }
}
