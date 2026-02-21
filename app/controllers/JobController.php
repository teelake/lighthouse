<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\ResumeUpload;

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
        $slug = $this->params['slug'] ?? '';
        $job = (new Job())->findBySlug($slug);
        if (!$job) throw new \Exception('Job not found', 404);

        if (!csrf_verify()) {
            $this->redirect('/jobs/' . $slug . '?error=error');
        }

        $firstName = trim($this->post('first_name', ''));
        $lastName = trim($this->post('last_name', ''));
        $email = trim($this->post('email', ''));
        $phone = trim($this->post('phone', ''));
        $ageRange = trim($this->post('age_range', ''));
        $engagementType = trim($this->post('engagement_type', ''));
        $message = trim($this->post('message', ''));

        if (!$firstName || !$lastName || !$email || !$phone || !$ageRange || !$engagementType) {
            $this->redirect('/jobs/' . $slug . '?error=required');
            return;
        }

        $resumeUploader = new ResumeUpload();
        $resumePath = $resumeUploader->upload('resume');
        if (!$resumePath) {
            $this->redirect('/jobs/' . $slug . '?error=' . ($resumeUploader->getLastError() ? 'resume' : 'required'));
            return;
        }

        $jobId = (int) $job['id'];
        $existing = (new JobApplication())->findAll(['job_id' => $jobId, 'email' => $email], '', 1);
        if (!empty($existing)) {
            $this->redirect('/jobs/' . $slug . '?error=duplicate');
            return;
        }

        try {
            $resumeUrl = rtrim(BASE_URL ?? '', '/') . '/' . ltrim($resumePath, '/');
            (new JobApplication())->create([
                'job_id' => $jobId,
                'job_title' => $job['title'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'phone' => $phone,
                'age_range' => $ageRange,
                'engagement_type' => $engagementType,
                'resume_path' => $resumeUrl,
                'message' => $message ?: null,
            ]);
            $this->redirect('/jobs/' . $slug . '?applied=1');
        } catch (\Throwable $e) {
            $this->redirect('/jobs/' . $slug . '?error=error');
        }
    }
}
