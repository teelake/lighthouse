<div class="admin-card">
    <a href="<?= admin_url('faqs') ?>" class="admin-back-link">← FAQs</a>
    <h2><?= $faq ? 'Edit FAQ' : 'Add FAQ' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $faq ? admin_url('faqs/' . $faq['id']) : admin_url('faqs') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" value="<?= htmlspecialchars($faq['question'] ?? '') ?>" required placeholder="e.g. Is Lighthouse open to everyone?">
        </div>
        <div class="form-group">
            <label>Answer</label>
            <textarea name="answer" class="rich-editor" style="min-height: 140px;"><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Plain text or HTML. Use formatting for lists, links, etc.</p>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= (int)($faq['sort_order'] ?? 0) ?>" min="0">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Lower numbers appear first.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $faq ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('faqs') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
