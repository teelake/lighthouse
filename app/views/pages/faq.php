<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <?php foreach ($faqs ?? [] as $faq): ?>
        <div style="margin: 1rem 0; padding: 1rem; background: #f1f5f9; border-radius: 8px;">
            <strong><?= htmlspecialchars($faq['question']) ?></strong>
            <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
        </div>
        <?php endforeach; ?>
        <?php if (empty($faqs)): ?>
        <p>Is Lighthouse Global Ministry open to everyone? Yes. We welcome people from all backgrounds.</p>
        <p>Do I need to be a member to attend? No. Membership is encouraged but not required.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
