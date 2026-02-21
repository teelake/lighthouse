<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$applied = isset($_GET['applied']);
$applyError = $_GET['error'] ?? null;
$jobTitle = htmlspecialchars($job['title'] ?? '');
$jobTypeLabel = htmlspecialchars(job_type_label($job['type'] ?? ''));
?>
<?php $jobsHeroImg = page_hero_image('jobs'); ?>
<section class="section job-apply-page" data-animate>
    <div class="page-hero page-hero--jobs<?= page_hero_classes($jobsHeroImg) ?>"<?= page_hero_style($jobsHeroImg) ?>>
        <div class="container">
            <nav class="job-apply-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= $baseUrl ?>/jobs">Jobs</a>
                <span class="job-apply-breadcrumb-sep" aria-hidden="true">/</span>
                <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>"><?= $jobTitle ?></a>
                <span class="job-apply-breadcrumb-sep" aria-hidden="true">/</span>
                <span class="job-apply-breadcrumb-current">Apply</span>
            </nav>
            <h1 class="page-hero-title">Apply for this role</h1>
            <p class="page-hero-sub"><?= $jobTitle ?> · <?= $jobTypeLabel ?></p>
        </div>
    </div>

    <div class="container job-apply-wrapper">
        <div class="job-apply-layout">
            <div class="job-apply-main">
                <?php if ($applied): ?>
                <div class="job-apply-card job-apply-success-card" role="alert">
                    <div class="job-apply-success-icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h2 class="job-apply-success-title">Application received</h2>
                    <p class="job-apply-success-text">Thank you for applying to <?= $jobTitle ?>. We've received your application and will review it shortly. Our team will be in touch if your experience matches what we're looking for.</p>
                    <div class="job-apply-success-actions">
                        <a href="<?= $baseUrl ?>/jobs" class="btn btn-primary">Browse other positions</a>
                        <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>" class="btn btn-outline">Back to job details</a>
                    </div>
                </div>
                <?php else: ?>
                <?php if ($applyError === 'duplicate'): ?>
                <div class="job-apply-card job-apply-msg-card job-apply-msg--error" role="alert">
                    <div class="job-apply-msg-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h2 class="job-apply-msg-title">Already applied</h2>
                    <p>You've already submitted an application for this position. We have your details on file and will contact you if there's a fit.</p>
                    <a href="<?= $baseUrl ?>/jobs" class="btn btn-primary">View other positions</a>
                </div>
                <?php else: ?>
                <?php if ($applyError): ?>
                <div class="job-apply-msg job-apply-msg--error" role="alert">
                    <span class="job-apply-msg-icon-sm" aria-hidden="true">!</span>
                    <?php
                    $errorMessages = [
                        'resume' => 'Please upload a valid resume: PDF or Word document (DOC/DOCX), maximum 5MB.',
                        'required' => 'Please fill in all required fields and upload your resume.',
                        'error' => 'Something went wrong. Please try again or contact us if the issue persists.',
                    ];
                    echo htmlspecialchars($errorMessages[$applyError] ?? 'Please check your input and try again.');
                    ?>
                </div>
                <?php endif; ?>

                <div class="job-apply-card job-apply-form-card">
                    <div class="job-apply-form-header">
                        <h2 class="job-apply-form-title">Application form</h2>
                        <p class="job-apply-form-lead">Complete the form below. Fields marked with <span class="job-apply-required" aria-hidden="true">*</span> are required.</p>
                    </div>
                    <form class="job-apply-form" action="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>/apply" method="post" enctype="multipart/form-data" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="job_id" value="<?= (int)($job['id'] ?? 0) ?>">

                        <fieldset class="job-apply-fieldset">
                            <legend class="job-apply-legend">Personal information</legend>
                            <div class="job-apply-grid">
                                <div class="job-apply-field">
                                    <label for="apply-first">First name <span class="job-apply-required" aria-hidden="true">*</span></label>
                                    <input type="text" id="apply-first" name="first_name" required maxlength="255" autocomplete="given-name" placeholder="John" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
                                </div>
                                <div class="job-apply-field">
                                    <label for="apply-last">Last name <span class="job-apply-required" aria-hidden="true">*</span></label>
                                    <input type="text" id="apply-last" name="last_name" required maxlength="255" autocomplete="family-name" placeholder="Smith" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="job-apply-field">
                                <label for="apply-email">Email address <span class="job-apply-required" aria-hidden="true">*</span></label>
                                <input type="email" id="apply-email" name="email" required maxlength="255" autocomplete="email" placeholder="john.smith@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="job-apply-field">
                                <label for="apply-phone">Phone number <span class="job-apply-required" aria-hidden="true">*</span></label>
                                <input type="tel" id="apply-phone" name="phone" required maxlength="50" autocomplete="tel" placeholder="e.g. (555) 123-4567" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                            </div>
                        </fieldset>

                        <fieldset class="job-apply-fieldset">
                            <legend class="job-apply-legend">Application details</legend>
                            <div class="job-apply-grid">
                                <div class="job-apply-field">
                                    <label for="apply-age">Age range <span class="job-apply-required" aria-hidden="true">*</span></label>
                                    <select id="apply-age" name="age_range" required aria-describedby="apply-age-hint">
                                        <option value="">Select your age range</option>
                                        <option value="13-17" <?= ($_POST['age_range'] ?? '') === '13-17' ? 'selected' : '' ?>>13–17</option>
                                        <option value="18-24" <?= ($_POST['age_range'] ?? '') === '18-24' ? 'selected' : '' ?>>18–24</option>
                                        <option value="25-30" <?= ($_POST['age_range'] ?? '') === '25-30' ? 'selected' : '' ?>>25–30</option>
                                        <option value="30-40" <?= ($_POST['age_range'] ?? '') === '30-40' ? 'selected' : '' ?>>30–40</option>
                                        <option value="40+" <?= ($_POST['age_range'] ?? '') === '40+' ? 'selected' : '' ?>>40+</option>
                                    </select>
                                </div>
                                <div class="job-apply-field">
                                    <label for="apply-engagement">Preferred engagement type <span class="job-apply-required" aria-hidden="true">*</span></label>
                                    <select id="apply-engagement" name="engagement_type" required>
                                        <option value="">Select type</option>
                                        <option value="full-time" <?= ($_POST['engagement_type'] ?? '') === 'full-time' ? 'selected' : '' ?>>Full-time</option>
                                        <option value="part-time" <?= ($_POST['engagement_type'] ?? '') === 'part-time' ? 'selected' : '' ?>>Part-time</option>
                                        <option value="full-time-part-time" <?= ($_POST['engagement_type'] ?? '') === 'full-time-part-time' ? 'selected' : '' ?>>Full-time / Part-time</option>
                                        <option value="internship" <?= ($_POST['engagement_type'] ?? '') === 'internship' ? 'selected' : '' ?>>Internship</option>
                                        <option value="volunteer" <?= ($_POST['engagement_type'] ?? '') === 'volunteer' ? 'selected' : '' ?>>Volunteer</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="job-apply-fieldset">
                            <legend class="job-apply-legend">Resume</legend>
                            <div class="job-apply-field job-apply-field--file">
                                <label for="apply-resume">Resume / CV <span class="job-apply-required" aria-hidden="true">*</span></label>
                                <div class="job-apply-file-wrap">
                                    <input type="file" id="apply-resume" name="resume" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required aria-describedby="apply-resume-hint">
                                    <span class="job-apply-file-label" aria-hidden="true">Choose file or drag and drop</span>
                                    <span class="job-apply-file-hint" id="apply-resume-hint">PDF, DOC or DOCX · Max 5MB</span>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="job-apply-fieldset">
                            <legend class="job-apply-legend">Additional information</legend>
                            <div class="job-apply-field">
                                <label for="apply-message">Cover letter or message <span class="job-apply-optional">(optional)</span></label>
                                <textarea id="apply-message" name="message" rows="5" placeholder="Tell us about yourself, your experience, and why you're interested in this role…" minlength="0"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                            </div>
                        </fieldset>

                        <div class="job-apply-form-actions">
                            <button type="submit" class="btn btn-primary job-apply-submit">
                                <span>Submit application</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            </button>
                            <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>" class="job-apply-cancel">Cancel and go back</a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>

            <aside class="job-apply-sidebar">
                <div class="job-apply-sidebar-card">
                    <h3 class="job-apply-sidebar-title">Applying for</h3>
                    <p class="job-apply-sidebar-job"><?= $jobTitle ?></p>
                    <p class="job-apply-sidebar-type"><?= $jobTypeLabel ?></p>
                    <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>" class="job-apply-sidebar-link">View full job details →</a>
                </div>
                <div class="job-apply-sidebar-card job-apply-sidebar-tips">
                    <h3 class="job-apply-sidebar-title">Tips</h3>
                    <ul class="job-apply-sidebar-list">
                        <li>Use a clear, up-to-date resume</li>
                        <li>Include relevant experience</li>
                        <li>Add a brief cover note if you can</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
