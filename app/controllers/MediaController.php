<?php
namespace App\Controllers;

use App\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $media = (new Media())->findAll(['is_published' => 1], 'published_at DESC', 24);
        $this->render('media/index', ['pageTitle' => 'Media & Teachings - Lighthouse Global Church', 'media' => $media]);
    }

    public function view()
    {
        $slug = $this->params['slug'] ?? '';
        $item = (new Media())->findBySlug($slug);
        if (!$item) throw new \Exception('Media not found', 404);
        $this->render('media/view', ['pageTitle' => $item['title'] . ' - Lighthouse Global Church', 'item' => $item]);
    }
}
