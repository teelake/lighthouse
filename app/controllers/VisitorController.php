<?php
namespace App\Controllers;

use App\Core\Controller;

class VisitorController extends Controller
{
    public function register()
    {
        // TODO: Save to DB, send email, auto-reply
        $this->redirect('/im-new?registered=1');
    }
}
