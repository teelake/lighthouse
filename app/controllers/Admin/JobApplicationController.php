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
            $a['job_title'] = $a['job_title'] ?? '';
            if (empty($a['job_title']) && !empty($a['job_id'])) {
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

    public function view()
    {
        $this->requireEditor();
        $id = (int) ($this->params['id'] ?? 0);
        $application = (new JobApplication())->find($id);
        if (!$application) {
            throw new \Exception('Application not found', 404);
        }
        $jobModel = new Job();
        if (empty($application['job_title']) && !empty($application['job_id'])) {
            $job = $jobModel->find($application['job_id']);
            $application['job_title'] = $job['title'] ?? '';
        }
        $job = null;
        if (!empty($application['job_id'])) {
            $job = $jobModel->find($application['job_id']);
        }
        $this->render('admin/job-applications/view', [
            'application' => $application,
            'job' => $job,
            'pageHeading' => 'Application Details',
            'currentPage' => 'jobs',
        ]);
    }
}
