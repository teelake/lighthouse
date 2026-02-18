<?php
namespace App\Controllers\Admin;

use App\Models\ContactSubmission;

class ContactReportController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();
        $submissions = (new ContactSubmission())->findAll([], 'created_at DESC', 200);
        $this->render('admin/contact-report/index', [
            'submissions' => $submissions,
            'pageHeading' => 'Contact Report',
            'currentPage' => 'contact-report',
        ]);
    }
}
