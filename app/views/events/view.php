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
            <?php
            $isTba    = empty($event['event_date']);
            $dateText = format_event_date($event['event_date'] ?? null, $event['event_end_date'] ?? null, $event['event_time'] ?? null, true);
            ?>
            <?php if ($isTba || !empty($event['location'])): ?>
            <div class="event-detail-meta">
                <?php if ($isTba): ?>
                <span class="event-detail-coming-soon">Coming Soon — date to be announced</span>
                <?php else: ?>
                <span><?= htmlspecialchars($dateText) ?></span>
                <?php endif; ?>
                <?php if (!empty($event['location'])): ?>
                <span><?= htmlspecialchars($event['location']) ?></span>
                <?php endif; ?>
            </div>
            <?php elseif (!$isTba): ?>
            <div class="event-detail-meta">
                <span><?= htmlspecialchars($dateText) ?></span>
            </div>
            <?php endif; ?>
            <div class="event-detail-desc"><?= rich_content($event['description'] ?? '') ?></div>
        </article>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
