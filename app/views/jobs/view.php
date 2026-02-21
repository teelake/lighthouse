<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$applied = isset($_GET['applied']);
$applyError = $_GET['error'] ?? null;
?>
<?php $jobsHeroImg = page_hero_image('jobs'); ?>
<section class="section job-view-page" data-animate>
    <div class="page-hero page-hero--jobs<?= page_hero_classes($jobsHeroImg) ?>"<?= page_hero_style($jobsHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title"><?= htmlspecialchars($job['title']) ?></h1>
            <p class="page-hero-sub"><?= htmlspecialchars(job_type_label($job['type'] ?? '')) ?></p>
        </div>
    </div>
    <div class="container job-view-content">
        <a href="<?= $baseUrl ?>/jobs" class="brand-back">← All Jobs</a>
        <div class="job-desc"><?= rich_content($job['description'] ?? '') ?></div>
        <a href="#apply" class="btn btn-watch job-apply-cta">Apply Now</a>

        <?php if ($applied): ?>
        <div class="job-apply-success" role="alert">
            <p>Thank you for applying! We've received your application and will be in touch.</p>
        </div>
        <?php endif; ?>
        <?php if ($applyError === 'duplicate'): ?>
        <div class="job-apply-msg job-apply-msg--error" role="alert">
            <p>You've already applied for this position. We have your application on file.</p>
        </div>
        <?php elseif ($applyError === 'resume'): ?>
        <div class="job-apply-msg job-apply-msg--error" role="alert">
            <p>Invalid resume. Please upload a PDF or Word document (max 5MB).</p>
        </div>
        <?php elseif ($applyError === 'required'): ?>
        <div class="job-apply-msg job-apply-msg--error" role="alert">
            <p>Please fill in all required fields and upload your resume.</p>
        </div>
        <?php elseif ($applyError === 'error'): ?>
        <div class="job-apply-msg job-apply-msg--error" role="alert">
            <p>Something went wrong. Please try again.</p>
        </div>
        <?php endif; ?>

        <div id="apply" class="job-apply-section">
            <h2 class="about-section-title">Apply for This Position</h2>
            <form class="job-apply-form" action="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>/apply" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="job_id" value="<?= (int)($job['id'] ?? 0) ?>">
                <div class="job-apply-grid">
                    <div class="form-group">
                        <label for="apply-first">First name <span aria-hidden="true">*</span></label>
                        <input type="text" id="apply-first" name="first_name" required maxlength="255" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="apply-last">Last name <span aria-hidden="true">*</span></label>
                        <input type="text" id="apply-last" name="last_name" required maxlength="255" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="apply-email">Email address <span aria-hidden="true">*</span></label>
                    <input type="email" id="apply-email" name="email" required maxlength="255" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="apply-phone">Phone number <span aria-hidden="true">*</span></label>
                    <input type="tel" id="apply-phone" name="phone" required maxlength="50" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="apply-age">Age range <span aria-hidden="true">*</span></label>
                    <select id="apply-age" name="age_range" required>
                        <option value="">Select age range</option>
                        <option value="13-17" <?= ($_POST['age_range'] ?? '') === '13-17' ? 'selected' : '' ?>>13-17</option>
                        <option value="18-24" <?= ($_POST['age_range'] ?? '') === '18-24' ? 'selected' : '' ?>>18-24</option>
                        <option value="25-30" <?= ($_POST['age_range'] ?? '') === '25-30' ? 'selected' : '' ?>>25-30</option>
                        <option value="30-40" <?= ($_POST['age_range'] ?? '') === '30-40' ? 'selected' : '' ?>>30-40</option>
                        <option value="40+" <?= ($_POST['age_range'] ?? '') === '40+' ? 'selected' : '' ?>>40+</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="apply-engagement">Preferred engagement type <span aria-hidden="true">*</span></label>
                    <select id="apply-engagement" name="engagement_type" required>
                        <option value="">Select type</option>
                        <option value="full-time" <?= ($_POST['engagement_type'] ?? '') === 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                        <option value="part-time" <?= ($_POST['engagement_type'] ?? '') === 'part-time' ? 'selected' : '' ?>>Part-Time</option>
                        <option value="full-time-part-time" <?= ($_POST['engagement_type'] ?? '') === 'full-time-part-time' ? 'selected' : '' ?>>Full-Time / Part-Time</option>
                        <option value="internship" <?= ($_POST['engagement_type'] ?? '') === 'internship' ? 'selected' : '' ?>>Internship</option>
                        <option value="volunteer" <?= ($_POST['engagement_type'] ?? '') === 'volunteer' ? 'selected' : '' ?>>Volunteer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="apply-resume">Resume / CV <span aria-hidden="true">*</span></label>
                    <input type="file" id="apply-resume" name="resume" accept=".pdf,.doc,.docx" required>
                    <p class="form-hint">PDF or Word document, max 5MB</p>
                </div>
                <div class="form-group">
                    <label for="apply-message">Cover letter or message (optional)</label>
                    <textarea id="apply-message" name="message" rows="4" placeholder="Tell us about yourself and why you're interested..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
