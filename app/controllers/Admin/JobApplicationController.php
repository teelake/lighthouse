<?php
namespace App\Controllers\Admin;

class JobApplicationController extends BaseController
{
    public function index() { $this->requireEditor(); $this->render('admin/job-applications/index', []); }
}
