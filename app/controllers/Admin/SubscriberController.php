<?php
namespace App\Controllers\Admin;

use App\Models\NewsletterSubscriber;

class SubscriberController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();
        $subscribers = (new NewsletterSubscriber())->findAll([], 'subscribed_at DESC', 100);
        $this->render('admin/subscribers/index', [
            'subscribers' => $subscribers,
            'pageHeading' => 'Newsletter Subscribers',
            'currentPage' => 'subscribers',
        ]);
    }
}
