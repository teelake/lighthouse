<?php
namespace App\Controllers\Admin;

use App\Models\JobApplication;
use App\Models\Job;

class JobApplicationController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $apps = (new JobApplication())->findAll([], 'created_at DESC', 50);
        $jobModel = new Job();
        foreach ($apps as &$a) {
            $a['job_title'] = '';
            if (!empty($a['job_id'])) {
                $job = $jobModel->find($a['job_id']);
                $a['job_title'] = $job['title'] ?? '';
            }
        }
        unset($a);
        $this->render('admin/job-applications/index', [
            'applications' => $apps,
            'pageHeading' => 'Job Applications',
            'currentPage' => 'jobs',
        ]);
    }
}
