<?php
namespace App\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        $jobs = (new Job())->findAll(['is_published' => 1], 'sort_order ASC');
        $this->render('jobs/index', ['pageTitle' => 'Jobs - Lighthouse Global Church', 'jobs' => $jobs]);
    }

    public function view()
    {
        $slug = $this->params['slug'] ?? '';
        $job = (new Job())->findBySlug($slug);
        if (!$job) throw new \Exception('Job not found', 404);
        $this->render('jobs/view', ['pageTitle' => $job['title'] . ' - Lighthouse Global Church', 'job' => $job]);
    }

    public function apply()
    {
        // TODO: Save application, send email
        $this->redirect('/jobs?applied=1');
    }
}
