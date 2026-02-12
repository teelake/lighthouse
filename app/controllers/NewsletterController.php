<?php
namespace App\Controllers;

class NewsletterController extends Controller
{
    public function subscribe()
    {
        // TODO: Save to DB, send confirmation
        $this->jsonResponse(['success' => true]);
    }
}
