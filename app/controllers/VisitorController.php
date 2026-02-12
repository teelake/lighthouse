<?php
namespace App\Controllers;

class VisitorController extends Controller
{
    public function register()
    {
        // TODO: Save to DB, send email, auto-reply
        $this->redirect('/im-new?registered=1');
    }
}
