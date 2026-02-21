<?php
$a = $application ?? [];
$displayName = trim(($a['first_name'] ?? '') . ' ' . ($a['last_name'] ?? '')) ?: ($a['name'] ?? '');
$baseUrl = rtrim(BASE_URL, '/');
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('job-applications') ?>" class="admin-back-link">← Job Applications</a>
            <h2>Application Details</h2>
        </div>
        <div class="admin-page-header-actions">
            <a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>?subject=Re: <?= rawurlencode($a['job_title'] ?? '') ?> Application" class="btn btn-primary">Contact Applicant</a>
        </div>
    </div>

    <div class="job-app-view">
        <section class="job-app-view-section">
            <h3 class="job-app-view-title">Position</h3>
            <p class="job-app-view-value"><?= htmlspecialchars($a['job_title'] ?? '—') ?></p>
            <?php if (!empty($job) && !empty($job['slug'])): ?>
            <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>" target="_blank" rel="noopener noreferrer" class="job-app-view-link">View job listing →</a>
            <?php endif; ?>
        </section>

        <section class="job-app-view-section">
            <h3 class="job-app-view-title">Personal Information</h3>
            <dl class="job-app-view-dl">
                <dt>Name</dt>
                <dd><?= htmlspecialchars($displayName) ?></dd>
                <dt>Email</dt>
                <dd><a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>"><?= htmlspecialchars($a['email'] ?? '—') ?></a></dd>
                <dt>Phone</dt>
                <dd><?= htmlspecialchars($a['phone'] ?? '—') ?></dd>
                <dt>Age range</dt>
                <dd><?= htmlspecialchars($a['age_range'] ?? '—') ?></dd>
                <dt>Preferred engagement type</dt>
                <dd><?= htmlspecialchars(engagement_type_label($a['engagement_type'] ?? '')) ?: '—' ?></dd>
            </dl>
        </section>

        <?php if (!empty($a['resume_path'])): ?>
        <section class="job-app-view-section">
            <h3 class="job-app-view-title">Resume</h3>
            <a href="<?= htmlspecialchars($a['resume_path']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline">View / Download Resume</a>
        </section>
        <?php endif; ?>

        <?php if (!empty($a['message'])): ?>
        <section class="job-app-view-section job-app-view-cover">
            <h3 class="job-app-view-title">Cover Letter / Message</h3>
            <div class="job-app-view-message"><?= nl2br(htmlspecialchars($a['message'])) ?></div>
        </section>
        <?php else: ?>
        <section class="job-app-view-section">
            <h3 class="job-app-view-title">Cover Letter / Message</h3>
            <p class="job-app-view-empty">No cover letter or message provided.</p>
        </section>
        <?php endif; ?>

        <section class="job-app-view-section job-app-view-meta">
            <h3 class="job-app-view-title">Submission</h3>
            <p class="job-app-view-value">Submitted on <?= htmlspecialchars($a['created_at'] ?? '') ?></p>
        </section>
    </div>
</div>
