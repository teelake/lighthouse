<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class JobApplicationController extends Controller
{
    public function index() { $this->requireAuth(); $this->render('admin/job-applications/index', []); }
}
