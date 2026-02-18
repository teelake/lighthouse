<div class="admin-card">
    <a href="<?= admin_url('visitors') ?>" class="admin-back-link">← Visitors</a>
    <h2><?= $visitor ? 'Edit Visitor' : 'Add Visitor' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $visitor ? admin_url('visitors/' . $visitor['id']) : admin_url('visitors') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars(($visitor ?? [])['first_name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars(($visitor ?? [])['last_name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars(($visitor ?? [])['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" value="<?= htmlspecialchars(($visitor ?? [])['phone'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Notes / Message</label>
            <textarea name="message" rows="3"><?= htmlspecialchars(($visitor ?? [])['message'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $visitor ? 'Update' : 'Add Visitor' ?></button>
            <a href="<?= admin_url('visitors') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
