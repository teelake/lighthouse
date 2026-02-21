<?php
namespace App\Controllers\Admin;

use App\Models\JobApplication;
use App\Models\Job;

class JobApplicationController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $perPage = 15;
        $page = max(1, (int) ($this->get('page') ?: 1));
        $offset = ($page - 1) * $perPage;

        $filters = [
            'job_id' => $this->get('job_id') ? (int) $this->get('job_id') : null,
            'engagement_type' => $this->get('engagement_type') ? trim($this->get('engagement_type')) : null,
            'date_from' => $this->get('date_from') ? trim($this->get('date_from')) : null,
            'date_to' => $this->get('date_to') ? trim($this->get('date_to')) : null,
            'search' => $this->get('search') ? trim($this->get('search')) : null,
        ];
        $filters = array_filter($filters);

        $result = (new JobApplication())->findAllFiltered($filters, 'created_at DESC', $perPage, $offset);
        $apps = $result['rows'];
        $total = $result['total'];

        $jobModel = new Job();
        $jobs = $jobModel->findAll([], 'title ASC', 200);
        foreach ($apps as &$a) {
            $a['job_title'] = $a['job_title'] ?? '';
            if (empty($a['job_title']) && !empty($a['job_id'])) {
                $job = $jobModel->find($a['job_id']);
                $a['job_title'] = $job['title'] ?? '';
            }
        }
        unset($a);

        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;

        $this->render('admin/job-applications/index', [
            'applications' => $apps,
            'jobs' => $jobs,
            'filters' => $filters,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => $totalPages,
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
