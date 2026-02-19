<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section event-detail-page">
    <div class="container">
        <a href="<?= $baseUrl ?>/events" class="event-detail-back">← All Events</a>
        <?php if (!empty($event['image'])): ?>
        <div class="event-detail-image">
            <img src="<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" loading="eager">
        </div>
        <?php endif; ?>
        <article class="event-detail-body">
            <h1><?= htmlspecialchars($event['title']) ?></h1>
            <?php if (!empty($event['event_date']) || !empty($event['location'])): ?>
            <div class="event-detail-meta">
                <?php if (!empty($event['event_date'])): ?>
                <span><?= date('l, F j, Y', strtotime($event['event_date'])) ?><?= !empty($event['event_time']) ? ' at ' . date('g:i A', strtotime($event['event_time'])) : '' ?></span>
                <?php endif; ?>
                <?php if (!empty($event['location'])): ?>
                <span><?= htmlspecialchars($event['location']) ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="event-detail-desc"><?= rich_content($event['description'] ?? '') ?></div>
        </article>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
