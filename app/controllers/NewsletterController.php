<?php
namespace App\Controllers;

use App\Core\Controller;

class NewsletterController extends Controller
{
    public function subscribe()
    {
        // TODO: Save to DB, send confirmation
        $this->jsonResponse(['success' => true]);
    }
}
