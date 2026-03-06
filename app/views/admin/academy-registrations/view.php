<?php
$r      = $row ?? [];
$labels = \App\Models\AcademyRegistration::$academyLabels;
$label  = $labels[$r['academy'] ?? ''] ?? ucfirst($r['academy'] ?? '');
$date   = !empty($r['created_at']) ? date('F j, Y \a\t g:i A', strtotime($r['created_at'])) : '';
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('academy-registrations') ?>" class="admin-back-link">← Academy Sign-Ups</a>
            <h2>Registration Details</h2>
        </div>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="mailto:<?= htmlspecialchars($r['email'] ?? '') ?>?subject=<?= rawurlencode('Re: ' . $label . ' — Lighthouse Global Church') ?>" class="btn btn-primary">Contact</a>
            <form method="post" action="<?= admin_url('academy-registrations/' . (int)($r['id'] ?? 0) . '/delete') ?>" onsubmit="return confirm('Delete this registration?');" style="margin:0;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="pw-view-card" style="max-width:600px;">
        <div class="pw-view-meta" style="margin-bottom:1.5rem;">
            <span class="acad-badge acad-badge--<?= htmlspecialchars($r['academy'] ?? '') ?>"><?= htmlspecialchars($label) ?></span>
            <?php if ($date): ?>
            <span class="pw-view-date">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?= $date ?>
            </span>
            <?php endif; ?>
        </div>

        <table class="acad-detail-table">
            <tr>
                <th>Full Name</th>
                <td><?= htmlspecialchars($r['full_name'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><a href="mailto:<?= htmlspecialchars($r['email'] ?? '') ?>"><?= htmlspecialchars($r['email'] ?? '') ?></a></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?= htmlspecialchars($r['phone'] ?? '—') ?></td>
            </tr>
            <tr>
                <th>Academy</th>
                <td><strong><?= htmlspecialchars($label) ?></strong></td>
            </tr>
            <?php if (!empty($r['message'])): ?>
            <tr>
                <th>Message</th>
                <td><?= nl2br(htmlspecialchars($r['message'])) ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
