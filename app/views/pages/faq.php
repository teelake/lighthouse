<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$faqs = $faqs ?? [];
?>
<section class="section faq-page" data-animate>
    <div class="page-hero page-hero--faq">
        <div class="container">
            <h1 class="page-hero-title">Frequently Asked Questions</h1>
            <p class="page-hero-sub">Quick answers to common questions</p>
        </div>
    </div>

    <div class="container faq-content">
        <?php if (!empty($faqs)): ?>
        <div class="faq-list" data-faq-accordion>
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item <?= $i === 0 ? 'is-open' : '' ?>">
                <button type="button" class="faq-question" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="faq-answer-<?= (int)$faq['id'] ?>" id="faq-q-<?= (int)$faq['id'] ?>" data-faq-toggle>
                    <?= htmlspecialchars($faq['question']) ?>
                    <span class="faq-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </button>
                <div class="faq-answer" id="faq-answer-<?= (int)$faq['id'] ?>" role="region" aria-labelledby="faq-q-<?= (int)$faq['id'] ?>">
                    <div class="faq-answer-inner">
                        <?= rich_content($faq['answer']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="faq-list" data-faq-accordion>
            <div class="faq-item is-open">
                <button type="button" class="faq-question" aria-expanded="true" data-faq-toggle>
                    Is Lighthouse open to everyone?
                    <span class="faq-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">Yes. We welcome people from all backgrounds. No matter where you are in your faith journey, you have a place here.</div>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question" aria-expanded="false" data-faq-toggle>
                    Do I need to be a member to attend?
                    <span class="faq-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">No. Membership is encouraged but not required. Feel free to attend services, small groups, and events as a visitor.</div>
                </div>
            </div>
            <div class="faq-item">
                <button type="button" class="faq-question" aria-expanded="false" data-faq-toggle>
                    What should I wear?
                    <span class="faq-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">Come as you are. Most people dress casually, though some prefer more formal attire. We care more about you than what you wear.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="faq-cta">
            <p>Didn't find your answer?</p>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-watch">Contact Us</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'FAQ - Lighthouse Global Church';
$pageDescription = 'Frequently asked questions about Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
