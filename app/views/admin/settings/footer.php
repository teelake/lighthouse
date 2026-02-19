<?php
$baseUrl = rtrim(BASE_URL, '/');
$defaultCols = [
    ['title' => 'ABOUT', 'links' => [
        ['label' => 'About Us', 'url' => '/about'],
        ['label' => 'Leadership', 'url' => '/leadership'],
        ['label' => 'FAQ', 'url' => '/faq'],
    ]],
    ['title' => 'GATHERINGS', 'links' => [
        ['label' => 'Services', 'url' => '/services'],
        ['label' => 'Events', 'url' => '/events'],
        ['label' => 'Ministries', 'url' => '/ministries'],
        ['label' => 'Media', 'url' => '/media'],
    ]],
    ['title' => 'GET INVOLVED', 'links' => [
        ['label' => "I'm New", 'url' => '/im-new'],
        ['label' => 'Small Groups', 'url' => '/small-groups'],
        ['label' => 'Membership & Training', 'url' => '/membership'],
        ['label' => 'Join the Team', 'url' => '/jobs'],
        ['label' => 'Prayer', 'url' => '/prayer'],
    ]],
    ['title' => 'CONTACT', 'links' => [
        ['label' => 'Contact Us', 'url' => '/contact'],
        ['label' => 'Giving', 'url' => '/giving'],
    ]],
];
$cols = $footer_columns ?? $defaultCols;
$tagline = $footer_tagline ?? 'Join us. Grow with us. Shine with us.';
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Footer Configuration</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/social') ?>" class="btn btn-outline btn-sm">Social</a>
        </div>
    </div>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Configure the footer tagline and link columns. Each column has a title and a list of links (label + URL).</p>
    <form method="post" action="<?= admin_url('settings/footer') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Footer Tagline</label>
            <input type="text" name="footer_tagline" value="<?= htmlspecialchars($tagline) ?>" placeholder="Join us. Grow with us. Shine with us.">
        </div>
        <?php foreach ($cols as $ci => $col): ?>
        <div class="footer-col-editor" style="border: 1px solid var(--adm-border); border-radius: 8px; padding: 1.25rem; margin-bottom: 1rem;">
            <h3 style="font-size: 1rem; margin: 0 0 1rem;">Column <?= $ci + 1 ?></h3>
            <div class="form-group">
                <label>Column Title</label>
                <input type="text" name="footer_col_<?= $ci ?>_title" value="<?= htmlspecialchars($col['title'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Links (one per line: Label|URL)</label>
                <textarea name="footer_col_<?= $ci ?>_links" rows="6" placeholder="About Us|/about"><?php
                $links = $col['links'] ?? [];
                foreach ($links as $l) {
                    echo htmlspecialchars(($l['label'] ?? '') . '|' . ($l['url'] ?? '')) . "\n";
                }
                ?></textarea>
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Format: Label|URL (e.g. About Us|/about). One per line.</p>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
