<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<?php $eventsHeroImg = page_hero_image('events'); ?>
<section class="section brand-page events-page" data-animate>
    <div class="page-hero page-hero--events<?= page_hero_classes($eventsHeroImg) ?>"<?= page_hero_style($eventsHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Events & Experiences</h1>
            <p class="page-hero-sub">What's happening</p>
        </div>
    </div>
    <div class="container brand-shell">
        <p class="brand-kicker">What's happening</p>
        <p class="brand-sub">Join worship gatherings, teaching nights, and transformative community moments.</p>
        <div class="events-grid">
        <?php foreach ($events ?? [] as $e): ?>
        <a href="<?= $baseUrl ?>/events/<?= htmlspecialchars($e['slug']) ?>" class="event-card-event">
            <?php if (!empty($e['image'])): ?>
            <div class="event-card-event-img" style="background-image: url('<?= htmlspecialchars($e['image']) ?>');"></div>
            <?php else: ?>
            <div class="event-card-event-img event-card-event-img--placeholder" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800');"></div>
            <?php endif; ?>
            <div class="event-card-event-body">
                <?php if (!empty($e['event_date'])): ?>
                <span class="event-card-event-date"><?= date('M j, Y', strtotime($e['event_date'])) ?><?= !empty($e['event_time']) ? ' · ' . date('g:i A', strtotime($e['event_time'])) : '' ?></span>
                <?php endif; ?>
                <h3><?= htmlspecialchars($e['title']) ?></h3>
                <p><?= rich_preview($e['description'], 120) ?></p>
                <span class="link-arrow">Details →</span>
            </div>
        </a>
        <?php endforeach; ?>
        </div>
        <?php if (empty($events)): ?>
        <p class="brand-empty">Events will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/" class="brand-back">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
